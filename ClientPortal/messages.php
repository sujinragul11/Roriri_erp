<?php
include("auth.php");

// Mark admin messages as read when the client opens the chat
mysqli_query($conn, "UPDATE client_message_tbl SET is_read=1 WHERE client_id=$clientId AND sender='admin' AND is_read=0");
include("portal_header.php");

// Load thread
$thread = [];
$tQ = mysqli_query($conn, "SELECT * FROM client_message_tbl WHERE client_id=$clientId ORDER BY msg_id ASC");
if ($tQ) { while ($t = mysqli_fetch_assoc($tQ)) { $thread[] = $t; } }
?>
<style>
    .chat-body { height: 500px; overflow-y: auto; }
    .send-row .form-control:focus, .send-row .btn:focus { box-shadow: none; }
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-transparent d-flex align-items-center">
                <div class="me-2"><div class="rounded-circle bg-danger text-white d-inline-flex align-items-center justify-content-center" style="width:40px;height:40px;"><i class="bx bx-shield-quarter"></i></div></div>
                <div><h6 class="mb-0">Chat with Admin</h6><small class="text-secondary">RORIRI Software Solutions</small></div>
            </div>
            <div class="card-body">
                <div class="chat-body chat-box" id="chatBox">
                    <?php if (count($thread) === 0): ?>
                        <div class="text-center text-secondary mt-4">No messages yet. Say hello!</div>
                    <?php else: foreach ($thread as $msg): ?>
                        <div class="bubble <?php echo ($msg['sender']=='client')?'client':'admin'; ?>">
                            <?php if (!empty($msg['message'])): ?>
                                <div><?php echo nl2br(htmlspecialchars($msg['message'])); ?></div>
                            <?php endif; ?>
                            <?php if ($msg['attachment_type']=='image' && !empty($msg['attachment_path'])): ?>
                                <a href="../<?php echo htmlspecialchars($msg['attachment_path']); ?>" target="_blank">
                                    <img src="../<?php echo htmlspecialchars($msg['attachment_path']); ?>" class="rounded mt-1" style="max-width:220px;max-height:220px;object-fit:cover;cursor:pointer;">
                                </a>
                            <?php elseif ($msg['attachment_type']=='voice' && !empty($msg['attachment_path'])): ?>
                                <audio controls class="mt-1" style="max-width:100%;max-height:40px;" src="../<?php echo htmlspecialchars($msg['attachment_path']); ?>"></audio>
                            <?php endif; ?>
                            <div class="msg-time"><?php echo date('d M Y h:i A', strtotime($msg['created_at'])); ?></div>
                        </div>
                    <?php endforeach; endif; ?>
                </div>

                <form id="msgForm" class="mt-3 send-row" enctype="multipart/form-data">
                    <input type="hidden" name="clientId" value="<?php echo $clientId; ?>">
                    <input type="file" name="attachment" id="clFileInput" accept="image/*,audio/webm,audio/*" style="display:none;">
                    <div class="input-group">
                        <div class="input-group-text p-0">
                            <button type="button" class="btn btn-light" id="clImgBtn" title="Send Image"><i class="bx bx-image-alt"></i></button>
                            <button type="button" class="btn btn-light" id="clVoiceBtn" title="Record Voice"><i class="bx bx-microphone"></i></button>
                        </div>
                        <input type="text" class="form-control" id="msgInput" placeholder="Type a message...">
                        <button type="submit" class="btn btn-primary" id="msgSend">Send</button>
                    </div>
                    <div id="clAttachPreview" class="mt-2 p-2 rounded bg-light d-none">
                        <strong>Attachment:</strong> <span id="clAttachLabel"></span>
                        <audio id="clVoicePreview" controls class="d-none" style="max-width:250px;"></audio>
                        <button type="button" class="btn btn-sm btn-outline-danger float-end" id="clClearAttach"><i class="bx bx-x"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    var chatBox = $('#chatBox');
    chatBox.scrollTop(chatBox[0].scrollHeight);

    var clMediaRecorder = null, clRecChunks = [], clVoiceFile = null, clImageFile = null, clVoiceUrl = null;

    function clearAttach() {
        clImageFile = null; clVoiceFile = null; clRecChunks = []; clVoiceUrl = null;
        $('#clAttachPreview').addClass('d-none');
        $('#clVoicePreview').addClass('d-none').attr('src', '').hide();
        $('#clFileInput').val('');
        $('#msgSend').html('Send');
    }
    function renderThread(thread, emptyText) {
        chatBox.empty();
        if (thread.length === 0) {
            chatBox.append('<div class="text-center text-secondary mt-4">' + emptyText + '</div>');
            return;
        }
        thread.forEach(function (m) {
            var cls = (m.sender === 'client') ? 'client' : 'admin';
            var media = '';
            if (m.attachment_type === 'image' && m.attachment_path) {
                media = '<a href="../' + m.attachment_path + '" target="_blank"><img src="../' + m.attachment_path + '" class="rounded mt-1" style="max-width:220px;max-height:220px;object-fit:cover;cursor:pointer;"></a>';
            } else if (m.attachment_type === 'voice' && m.attachment_path) {
                media = '<audio controls class="mt-1" style="max-width:100%;max-height:40px;" src="../' + m.attachment_path + '"></audio>';
            }
            var text = m.message ? '<div>' + $('<div>').text(m.message).html() + '</div>' : '';
            chatBox.append('<div class="bubble ' + cls + '">' + text + media + '<div class="msg-time">' + m.created_at + '</div></div>');
        });
        chatBox.scrollTop(chatBox[0].scrollHeight);
    }

    $('#clFileInput').on('change', function () {
        var f = this.files[0];
        if (!f) return;
        clearAttach();
        if (f.type.indexOf('image/') === 0) {
            clImageFile = f;
            $('#clAttachPreview').removeClass('d-none');
            $('#clAttachLabel').text('Image: ' + f.name);
            $('#msgSend').html('<i class="bx bx-image-alt"></i> Send Image');
        } else if (f.type.indexOf('audio/') === 0 || f.type === 'video/webm') {
            clVoiceFile = f;
            $('#clAttachPreview').removeClass('d-none');
            $('#clAttachLabel').text('Voice: ' + f.name);
            $('#clVoicePreview').attr('src', URL.createObjectURL(f)).removeClass('d-none').show();
            $('#msgSend').html('<i class="bx bx-microphone"></i> Send Voice');
        }
    });
    $('#clImgBtn').on('click', function () { $('#clFileInput').attr('accept', 'image/*').trigger('click'); });
    $('#clVoiceBtn').on('click', function () {
        if (!navigator.mediaDevices || !window.MediaRecorder) {
            alert('Voice recording is not supported in this browser. You can upload an audio file via the paperclip.');
            return;
        }
        if (clMediaRecorder && clMediaRecorder.state === 'recording') { clMediaRecorder.stop(); return; }
        navigator.mediaDevices.getUserMedia({ audio: true }).then(function (stream) {
            clMediaRecorder = new MediaRecorder(stream);
            clMediaRecorder.start(); clRecChunks = [];
            $('#clVoiceBtn').addClass('btn-danger').html('<i class="bx bx-stop"></i> Stop');
            clMediaRecorder.ondataavailable = function (e) { if (e.data.size > 0) clRecChunks.push(e.data); };
            clMediaRecorder.onstop = function () {
                stream.getTracks().forEach(function (t) { t.stop(); });
                $('#clVoiceBtn').removeClass('btn-danger').html('<i class="bx bx-microphone"></i>');
                var blob = new Blob(clRecChunks, { type: 'audio/webm' });
                if (blob.size === 0) { alert('No voice captured.'); return; }
                clearAttach();
                clVoiceFile = blob; clVoiceUrl = URL.createObjectURL(blob);
                $('#clAttachPreview').removeClass('d-none');
                $('#clAttachLabel').text('Voice note (recorded)');
                $('#clVoicePreview').attr('src', clVoiceUrl).removeClass('d-none').show();
                $('#msgSend').html('<i class="bx bx-microphone"></i> Send Voice');
            };
        }).catch(function () { alert('Microphone access was denied.'); });
    });
    $('#clClearAttach').on('click', clearAttach);

    $('#msgForm').on('submit', function (e) {
        e.preventDefault();
        var message = $('#msgInput').val().trim();
        var hasAttach = (clImageFile !== null || clVoiceFile !== null);
        if (!message && !hasAttach) return;
        var fd = new FormData();
        fd.append('hdnAction', 'sendMessage');
        fd.append('message', message);
        if (clVoiceFile) { fd.append('attachment', clVoiceFile, 'voice_' + Date.now() + '.webm'); }
        else if (clImageFile) { fd.append('attachment', clImageFile); }
        $('#msgSend').prop('disabled', true);
        $.ajax({
            url: 'action/actPortal.php',
            method: 'POST',
            data: fd, processData: false, contentType: false,
            dataType: 'json',
            success: function (res) {
                $('#msgSend').prop('disabled', false);
                if (res.success) {
                    $('#msgInput').val(''); clearAttach();
                    location.reload();
                } else { alert(res.message); }
            },
            error: function () { $('#msgSend').prop('disabled', false); alert('An error occurred.'); }
        });
    });

    // Auto-refresh every 4s
    setInterval(function () {
        $.ajax({
            url: 'action/actPortal.php?hdnAction=fetchThread',
            method: 'GET',
            dataType: 'json',
            success: function (res) {
                if (res.success) renderThread(res.thread, 'No messages yet. Say hello!');
            }
        });
    }, 4000);
});
</script>
<?php include("portal_footer.php"); ?>
