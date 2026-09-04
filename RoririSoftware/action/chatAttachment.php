<?php

function handleChatAttachmentUpload() {
    $result = ['success' => false, 'type' => null, 'path' => null, 'message' => ''];

    if (empty($_FILES['attachment']) || $_FILES['attachment']['error'] !== UPLOAD_ERR_OK) {
        $result['message'] = 'No file uploaded.';
        return $result;
    }

    $file = $_FILES['attachment'];
    $tmp = $file['tmp_name'];
    $name = $file['name'];
    $size = $file['size'];

    $maxSize = 25 * 1024 * 1024; // 25 MB
    if ($size > $maxSize) {
        $result['message'] = 'File too large (max 25 MB).';
        return $result;
    }

    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    $imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];

    $isImage = in_array($ext, $imageExts);
    $isVoice = in_array($ext, ['webm', 'ogg', 'mp3', 'wav', 'm4a', 'oga', 'mp4']);
    $type = null;

    if ($isImage) {
        $type = 'image';
    } elseif ($isVoice) {
        $type = 'voice';
    } else {
        $mime = isset($file['type']) ? $file['type'] : '';
        if (strpos($mime, 'image/') === 0) {
            $type = 'image';
        } elseif (strpos($mime, 'audio/') === 0 || strpos($mime, 'video/webm') === 0 || strpos($mime, 'application/ogg') === 0) {
            $type = 'voice';
        }
    }

    if ($type === null) {
        $result['message'] = 'Only images and audio/video (voice) files are supported.';
        return $result;
    }

    $baseDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'chat';
    if (!is_dir($baseDir)) {
        @mkdir($baseDir, 0755, true);
    }
    if (!is_writable($baseDir)) {
        $result['message'] = 'Upload directory is not writable.';
        return $result;
    }

    $prefix = ($type === 'image') ? 'img' : 'voice';
    $filename = $prefix . '_' . date('Ymd_His') . '_' . uniqid() . '.' . $ext;
    $absPath = $baseDir . DIRECTORY_SEPARATOR . $filename;

    if (!move_uploaded_file($tmp, $absPath)) {
        $result['message'] = 'Failed to save the file.';
        return $result;
    }

    $result['success'] = true;
    $result['type'] = $type;
    $result['path'] = 'assets/chat/' . $filename;
    $result['message'] = 'File uploaded.';
    return $result;
}
