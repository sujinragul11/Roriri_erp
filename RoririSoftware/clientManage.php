<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");

$clients = [];
$cQ = mysqli_query($conn, "SELECT client_id, client_name, client_company, client_points FROM client_tbl WHERE client_status='Active' ORDER BY client_name");
if ($cQ) { while ($c = mysqli_fetch_assoc($cQ)) { $clients[] = $c; } }

// Load data for a selected client
$selClientId = (isset($_GET['client_id']) && $_GET['client_id'] != '') ? (int)$_GET['client_id'] : null;
$selClient = null;
if ($selClientId) {
    $sc = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM client_tbl WHERE client_id=$selClientId AND client_status='Active'"));
    if ($sc) { $selClient = $sc; }
}

$messages = [];
$requirements = [];
$referrals = [];
$tickets = [];
$feedbacks = [];
if ($selClientId) {
    $mq = mysqli_query($conn, "SELECT * FROM client_message_tbl WHERE client_id=$selClientId ORDER BY msg_id ASC");
    if ($mq) { while ($m = mysqli_fetch_assoc($mq)) { $messages[] = $m; } }
    $rq = mysqli_query($conn, "SELECT * FROM client_project_req_tbl WHERE client_id=$selClientId ORDER BY req_id DESC");
    if ($rq) { while ($r = mysqli_fetch_assoc($rq)) { $requirements[] = $r; } }
    $rf = mysqli_query($conn, "SELECT * FROM client_referral_tbl WHERE referring_client_id=$selClientId ORDER BY ref_id DESC");
    if ($rf) { while ($r = mysqli_fetch_assoc($rf)) { $referrals[] = $r; } }
    $tq = mysqli_query($conn, "SELECT * FROM client_support_tbl WHERE client_id=$selClientId ORDER BY ticket_id DESC");
    if ($tq) { while ($t = mysqli_fetch_assoc($tq)) { $tickets[] = $t; } }
    $fq = mysqli_query($conn, "SELECT f.*, p.project_name FROM client_feedback_tbl f LEFT JOIN project_tbl p ON f.project_id=p.project_id WHERE f.client_id=$selClientId ORDER BY f.feedback_id DESC");
    if ($fq) { while ($f = mysqli_fetch_assoc($fq)) { $feedbacks[] = $f; } }
}
?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
			<?php include("left.php");?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php include("top.php");?>
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">

				<div class="page-title-box d-flex justify-content-between align-items-center mb-3">
					<h2 class="page-title mb-0">Client Portal Management</h2>
				</div>

				<!-- Client selector -->
				<div class="card mb-3">
					<div class="card-body">
						<form method="GET" action="clientManage.php" class="row g-2 align-items-end">
							<div class="col-md-5">
								<label class="form-label">Select Client</label>
								<select name="client_id" id="clientSelect" class="form-control" onchange="this.form.submit()">
									<option value="">-- Select a client --</option>
									<?php foreach ($clients as $cl): ?>
										<option value="<?php echo $cl['client_id']; ?>" <?php echo ($selClientId == $cl['client_id'])?'selected':''; ?>>
											<?php echo htmlspecialchars($cl['client_name'] . ' (' . $cl['client_company'] . ') - ' . $cl['client_points'] . ' pts'); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
						</form>
					</div>
				</div>

				<?php if (!$selClient): ?>
					<div class="alert alert-info">Select a client to manage messages, requirements, referrals, points and support tickets.</div>
				<?php else: ?>

				<div class="d-flex justify-content-between align-items-center mb-3">
					<h5 class="mb-0">
						<?php echo htmlspecialchars($selClient['client_name']); ?>
						<span class="text-secondary fw-normal">(<?php echo htmlspecialchars($selClient['client_company']); ?>)</span>
					</h5>
					<div>
						<span class="badge bg-warning text-dark fs-6">Points: <?php echo (int)$selClient['client_points']; ?></span>
						<span class="badge bg-secondary fs-6 ms-1"><?php echo htmlspecialchars($selClient['client_username']); ?></span>
					</div>
				</div>

				<ul class="nav nav-tabs mb-3" id="cmTabs" role="tablist">
					<li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabMsg" type="button">Messages (<?php echo count($messages); ?>)</button></li>
					<li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabReq" type="button">Requirements (<?php echo count($requirements); ?>)</button></li>
					<li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabRef" type="button">Referrals (<?php echo count($referrals); ?>)</button></li>
					<li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabPoints" type="button">Points</button></li>
					<li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabTicket" type="button">Support (<?php echo count($tickets); ?>)</button></li>
					<li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabFb" type="button">Feedback (<?php echo count($feedbacks); ?>)</button></li>
				</ul>

				<div class="tab-content">
					<!-- Messages -->
					<div class="tab-pane fade show active" id="tabMsg">
						<div class="card">
							<div class="card-body">
								<div class="mb-3" style="max-height:300px;overflow-y:auto;background:#f8f9fa;border-radius:8px;padding:12px;">
									<?php if (count($messages) === 0): ?>
										<div class="text-center text-secondary">No messages yet.</div>
									<?php else: foreach ($messages as $m): ?>
										<div class="<?php echo ($m['sender']=='admin')?'text-start':'text-end'; ?> mb-2">
											<span class="badge <?php echo ($m['sender']=='admin')?'bg-danger':'bg-primary'; ?>">
												<?php echo ($m['sender']=='admin')?'Admin':'Client'; ?>
											</span>
											<div class="p-2 rounded d-inline-block bg-<?php echo ($m['sender']=='admin')?'-light-danger text-danger':'light text-primary'; ?>" style="max-width:75%;">
												<?php if (!empty($m['message'])): ?>
													<div><?php echo nl2br(htmlspecialchars($m['message'])); ?></div>
												<?php endif; ?>
												<?php if ($m['attachment_type']=='image' && !empty($m['attachment_path'])): ?>
													<a href="../<?php echo htmlspecialchars($m['attachment_path']); ?>" target="_blank">
														<img src="../<?php echo htmlspecialchars($m['attachment_path']); ?>" class="rounded mt-1" style="max-width:220px;max-height:220px;object-fit:cover;cursor:pointer;">
													</a>
												<?php elseif ($m['attachment_type']=='voice' && !empty($m['attachment_path'])): ?>
													<audio controls class="mt-1" style="max-width:100%;" src="../<?php echo htmlspecialchars($m['attachment_path']); ?>"></audio>
												<?php endif; ?>
											</div>
											<div class="small text-muted"><?php echo date('d M Y h:i A', strtotime($m['created_at'])); ?></div>
										</div>
									<?php endforeach; endif; ?>
								</div>
								<form id="sendMsgForm" class="mt-2" enctype="multipart/form-data">
									<input type="hidden" name="clientId" value="<?php echo $selClientId; ?>">
									<input type="hidden" name="admAttachType" id="admAttachType">
									<input type="file" name="attachment" id="admFileInput" accept="image/*,audio/webm,audio/*" style="display:none;">
									<div class="input-group">
										<div class="input-group-text p-0">
											<button type="button" class="btn btn-light" id="admImgBtn" title="Send Image"><i class="bx bx-image-alt"></i></button>
											<button type="button" class="btn btn-light" id="admVoiceBtn" title="Record Voice"><i class="bx bx-microphone"></i></button>
										</div>
										<input type="text" class="form-control" id="admMsgInput" placeholder="Type a message...">
										<button type="submit" class="btn btn-primary" id="sendMsgBtn">Send</button>
									</div>
									<div id="admAttachPreview" class="mt-2 p-2 rounded bg-light d-none">
										<strong>Attachment:</strong> <span id="admAttachLabel"></span>
										<audio id="admVoicePreview" controls class="d-none" style="max-width:250px;"></audio>
										<button type="button" class="btn btn-sm btn-outline-danger float-end" id="admClearAttach"><i class="bx bx-x"></i></button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<!-- Requirements -->
					<div class="tab-pane fade" id="tabReq">
						<div class="card">
							<div class="card-body p-0">
								<div class="table-responsive">
									<table class="table table-striped mb-0 align-middle">
										<thead><tr><th>#</th><th>Title</th><th>Description</th><th>Budget</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>
										<tbody>
										<?php if (count($requirements) === 0): ?>
											<tr><td colspan="7" class="text-center text-secondary">No requirements submitted.</td></tr>
										<?php else: foreach ($requirements as $r): ?>
											<tr>
												<td><?php echo $r['req_id']; ?></td>
												<td><?php echo htmlspecialchars($r['project_title']); ?></td>
												<td><?php echo htmlspecialchars(mb_strimwidth($r['description'],0,50,'…')); ?></td>
												<td><?php echo $r['budget'] !== null ? '₹'.number_format((float)$r['budget']) : '—'; ?></td>
												<td><span class="badge bg-<?php echo ($r['status']=='Approved')?'success':(($r['status']=='Rejected')?'danger':'secondary'); ?>"><?php echo htmlspecialchars($r['status']); ?></span></td>
												<td><?php echo date('d M Y', strtotime($r['created_at'])); ?></td>
												<td>
													<select class="form-select form-select-sm reqStatus" data-id="<?php echo $r['req_id']; ?>">
														<option value="Pending" <?php echo ($r['status']=='Pending')?'selected':''; ?>>Pending</option>
														<option value="In Progress" <?php echo ($r['status']=='In Progress')?'selected':''; ?>>In Progress</option>
														<option value="Approved" <?php echo ($r['status']=='Approved')?'selected':''; ?>>Approved</option>
														<option value="Rejected" <?php echo ($r['status']=='Rejected')?'selected':''; ?>>Rejected</option>
													</select>
												</td>
											</tr>
										<?php endforeach; endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					<!-- Referrals -->
					<div class="tab-pane fade" id="tabRef">
						<div class="card">
							<div class="card-body p-0">
								<div class="table-responsive">
									<table class="table table-striped mb-0 align-middle">
										<thead><tr><th>Referred Client</th><th>Points</th><th>Status</th><th>Date</th></tr></thead>
										<tbody>
										<?php if (count($referrals) === 0): ?>
											<tr><td colspan="4" class="text-center text-secondary">No referrals made.</td></tr>
										<?php else: foreach ($referrals as $rf): ?>
											<tr>
												<td><?php echo htmlspecialchars($rf['referred_name']); ?></td>
												<td><?php echo (int)$rf['points']; ?></td>
												<td><span class="badge bg-<?php echo ($rf['status']=='Credited')?'success':'secondary'; ?>"><?php echo htmlspecialchars($rf['status']); ?></span></td>
												<td><?php echo date('d M Y', strtotime($rf['created_at'])); ?></td>
											</tr>
										<?php endforeach; endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					<!-- Points -->
					<div class="tab-pane fade" id="tabPoints">
						<div class="card">
							<div class="card-body">
								<div class="mb-3"><strong>Current Balance:</strong> <span class="badge bg-warning text-dark fs-5"><?php echo (int)$selClient['client_points']; ?> points</span></div>
								<form id="pointsForm" class="row g-2 align-items-end">
									<input type="hidden" name="clientId" value="<?php echo $selClientId; ?>">
									<div class="col-md-3">
										<label class="form-label">Adjust Points (+/-)</label>
										<input type="number" class="form-control" id="adjPoints" placeholder="e.g. -5 or +10">
									</div>
									<div class="col-md-6">
										<label class="form-label">Reason</label>
										<input type="text" class="form-control" id="adjReason" placeholder="e.g. Bonus for referral">
									</div>
									<div class="col-md-3">
										<button type="submit" class="btn btn-warning w-100" id="adjBtn">Apply</button>
									</div>
								</form>
								<div class="small text-muted mt-2">Referral rule: 15 points = 1% of the referred client's first project amount (auto-credited).</div>
							</div>
						</div>
					</div>

					<!-- Support -->
					<div class="tab-pane fade" id="tabTicket">
						<div class="card">
							<div class="card-body p-0">
								<div class="table-responsive">
									<table class="table table-striped mb-0 align-middle">
										<thead><tr><th>#</th><th>Subject</th><th>Priority</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>
										<tbody>
										<?php if (count($tickets) === 0): ?>
											<tr><td colspan="6" class="text-center text-secondary">No support tickets.</td></tr>
										<?php else: foreach ($tickets as $tk): ?>
											<tr>
												<td>#<?php echo $tk['ticket_id']; ?></td>
												<td><?php echo htmlspecialchars(mb_strimwidth($tk['subject'],0,40,'…')); ?></td>
												<td><span class="badge bg-<?php echo ($tk['priority']=='High')?'danger':(($tk['priority']=='Low')?'info':'secondary'); ?>"><?php echo htmlspecialchars($tk['priority']); ?></span></td>
												<td><span class="badge bg-<?php echo ($tk['status']=='Closed')?'success':'warning'; ?>"><?php echo htmlspecialchars($tk['status']); ?></span></td>
												<td><?php echo date('d M Y', strtotime($tk['created_at'])); ?></td>
												<td><button class="btn btn-sm btn-outline-primary" onclick="openTicket(<?php echo $tk['ticket_id']; ?>)"><i class="bx bx-show"></i></button></td>
											</tr>
										<?php endforeach; endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					<!-- Feedback -->
					<div class="tab-pane fade" id="tabFb">
						<div class="card">
							<div class="card-body p-0">
								<div class="table-responsive">
									<table class="table table-striped mb-0 align-middle">
										<thead><tr><th>Project</th><th>Rating</th><th>Comments</th><th>Date</th></tr></thead>
										<tbody>
										<?php if (count($feedbacks) === 0): ?>
											<tr><td colspan="4" class="text-center text-secondary">No feedback submitted.</td></tr>
										<?php else: foreach ($feedbacks as $f): ?>
											<tr>
												<td><?php echo $f['project_name'] ? htmlspecialchars($f['project_name']) : '—'; ?></td>
												<td><?php echo $f['rating'] ? str_repeat('★',(int)$f['rating']).str_repeat('☆',5-(int)$f['rating']) : '—'; ?></td>
												<td><?php echo htmlspecialchars(mb_strimwidth($f['comments'],0,60,'…')); ?></td>
												<td><?php echo date('d M Y', strtotime($f['created_at'])); ?></td>
											</tr>
										<?php endforeach; endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php endif; ?>

			</div>
		</div><!--end page-wrapper-->
	</div><!--end wrapper-->

	<!-- Support ticket modal -->
	<div class="modal fade" id="ticketModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header"><h6 class="modal-title">Ticket #<span id="tkIdLabel"></span></h6><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
				<div class="modal-body">
					<input type="hidden" id="tkId">
					<p><strong>Subject:</strong> <span id="tkSubject"></span></p>
					<p><strong>Description:</strong></p>
					<p style="white-space:pre-wrap;" id="tkDesc"></p>
					<hr>
					<label class="form-label">Admin Reply</label>
					<textarea class="form-control" id="tkReply" rows="3" placeholder="Type a reply..."></textarea>
					<label class="form-label mt-2">Status</label>
					<select class="form-control" id="tkStatus">
						<option value="Open">Open</option>
						<option value="In Progress">In Progress</option>
						<option value="Closed">Closed</option>
					</select>
					<p class="mt-2" id="tkExistingReply"></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="tkSave">Save Reply</button>
				</div>
			</div>
		</div>
	</div>

	<?php include("theme.php");?>
	<script src="<?php echo $bootsrapBundle; ?>"></script>
	<script src="<?php echo $js; ?>"></script>
	<script src="<?php echo $simplebar;?>"></script>
	<script src="<?php echo $mentimenu; ?>"></script>
	<script src="<?php echo $perfectScrolbar;  ?>"></script>
	<script src="<?php echo $datatableMin; ?>"></script>
	<script src="<?php echo $datatbaleBootstrap;?>"></script>
	<script src="<?php echo $popper;?>"></script>
	<script src="<?php echo $bootStackPath;?>"></script>

	<script>
	var TICKETS = <?php echo json_encode($tickets); ?>;
	function openTicket(id) {
		var t = TICKETS.find(function (x) { return x.ticket_id == id; });
		if (!t) return;
		$('#tkId').val(t.ticket_id);
		$('#tkIdLabel').text(t.ticket_id);
		$('#tkSubject').text(t.subject);
		$('#tkDesc').text(t.description);
		$('#tkReply').val('');
		$('#tkStatus').val(t.status);
		$('#tkExistingReply').html(t.admin_reply ? '<strong>Previous reply:</strong><br>' + $('<div>').text(t.admin_reply).html() : '');
		$('#ticketModal').modal('show');
	}
	$(document).ready(function () {
		// Send message (text + optional image/voice attachment)
		var admMediaRecorder = null, admRecChunks = [], admVoiceFile = null, admImageFile = null;

		function admSetAttach(label, file, kind, audioUrl) {
			$('#admAttachPreview').removeClass('d-none');
			$('#admAttachLabel').text(label);
			if (kind === 'voice' && audioUrl) {
				$('#admVoicePreview').attr('src', audioUrl).removeClass('d-none').show();
			} else {
				$('#admVoicePreview').addClass('d-none').attr('src', '').hide();
			}
			if (kind === 'image') { admImageFile = file; }
			if (kind === 'voice') { admVoiceFile = file; }
			$('#sendMsgBtn').html(kind === 'voice' ? '<i class="bx bx-send"></i> Send Voice' : 'Send');
		}
		function admClearAttach() {
			admImageFile = null; admVoiceFile = null; admRecChunks = [];
			$('#admAttachPreview').addClass('d-none');
			$('#admVoicePreview').addClass('d-none').attr('src', '').hide();
			$('#admFileInput').val('');
			$('#sendMsgBtn').html('Send');
		}
		$('#admFileInput').on('change', function () {
			var f = this.files[0];
			if (!f) return;
			if (f.type.indexOf('image/') === 0) {
				admClearAttach();
				admImageFile = f;
				$('#admAttachPreview').removeClass('d-none');
				$('#admAttachLabel').text('Image: ' + f.name);
				$('#admVoicePreview').addClass('d-none').hide();
				$('#sendMsgBtn').html('<i class="bx bx-image-alt"></i> Send Image');
			} else if (f.type.indexOf('audio/') === 0 || f.type === 'video/webm') {
				admClearAttach();
				admVoiceFile = f;
				$('#admAttachPreview').removeClass('d-none');
				$('#admAttachLabel').text('Voice: ' + f.name);
				$('#admVoicePreview').attr('src', URL.createObjectURL(f)).removeClass('d-none').show();
				$('#sendMsgBtn').html('<i class="bx bx-microphone"></i> Send Voice');
			}
		});
		$('#admImgBtn').on('click', function () { $('#admFileInput').attr('accept', 'image/*').trigger('click'); });
		$('#admVoiceBtn').on('click', function () {
			if (!navigator.mediaDevices || !window.MediaRecorder) {
				alert('Voice recording is not supported in this browser. You can upload an audio file instead via the paperclip.');
				return;
			}
			if (admMediaRecorder && admMediaRecorder.state === 'recording') {
				admMediaRecorder.stop();
				return;
			}
			navigator.mediaDevices.getUserMedia({ audio: true }).then(function (stream) {
				admMediaRecorder = new MediaRecorder(stream);
				admMediaRecorder.start(); admRecChunks = [];
				$('#admVoiceBtn').addClass('btn-danger').html('<i class="bx bx-stop"></i> Stop');
				admMediaRecorder.ondataavailable = function (e) { if (e.data.size > 0) { admRecChunks.push(e.data); } };
				admMediaRecorder.onstop = function () {
					stream.getTracks().forEach(function (t) { t.stop(); });
					$('#admVoiceBtn').removeClass('btn-danger').html('<i class="bx bx-microphone"></i>');
					var blob = new Blob(admRecChunks, { type: 'audio/webm' });
					if (blob.size === 0) { alert('No voice captured.'); return; }
					admClearAttach();
					var url = URL.createObjectURL(blob);
					admSetAttach('Voice note (recorded)', blob, 'voice', url);
				};
			}).catch(function () { alert('Microphone access was denied.'); });
		});
		$('#admClearAttach').on('click', admClearAttach);

		$('#sendMsgForm').on('submit', function (e) {
			e.preventDefault();
			var msg = $('#admMsgInput').val().trim();
			var cid = $(this).find('input[name=clientId]').val();
			var hasAttach = (admImageFile !== null || admVoiceFile !== null);
			if (!msg && !hasAttach) return;
			var fd = new FormData();
			fd.append('hdnAction', 'adminSendMessage');
			fd.append('clientId', cid);
			fd.append('message', msg);
			if (admVoiceFile) { fd.append('attachment', admVoiceFile, 'voice_' + Date.now() + '.webm'); }
			else if (admImageFile) { fd.append('attachment', admImageFile); }
			$('#sendMsgBtn').prop('disabled', true);
			$.ajax({
				url: 'action/actClientManage.php', method: 'POST',
				data: fd, processData: false, contentType: false,
				dataType: 'json',
				success: function (res) {
					$('#sendMsgBtn').prop('disabled', false);
					if (res.success) { $('#admMsgInput').val(''); admClearAttach(); location.reload(); } else { alert(res.message); }
				},
				error: function () { $('#sendMsgBtn').prop('disabled', false); alert('An error occurred.'); }
			});
		});
		// Requirement status
		$('.reqStatus').on('change', function () {
			var reqId = $(this).data('id'); var status = $(this).val();
			$.ajax({
				url: 'action/actClientManage.php', method: 'POST',
				data: { hdnAction: 'updateRequirement', reqId: reqId, status: status },
				dataType: 'json',
				success: function (res) { alert(res.message); }
			});
		});
		// Points
		$('#pointsForm').on('submit', function (e) {
			e.preventDefault();
			var cid = $(this).find('input[name=clientId]').val();
			$.ajax({
				url: 'action/actClientManage.php', method: 'POST',
				data: { hdnAction: 'adjustPoints', clientId: cid, points: $('#adjPoints').val(), reason: $('#adjReason').val() },
				dataType: 'json',
				success: function (res) {
					if (res.success) { location.reload(); } else { alert(res.message); }
				}
			});
		});
		// Save ticket
		$('#tkSave').on('click', function () {
			$.ajax({
				url: 'action/actClientManage.php', method: 'POST',
				data: { hdnAction: 'updateTicket', ticketId: $('#tkId').val(), reply: $('#tkReply').val(), status: $('#tkStatus').val() },
				dataType: 'json',
				success: function (res) {
					if (res.success) { $('#ticketModal').modal('hide'); location.reload(); } else { alert(res.message); }
				}
			});
		});
	});
	</script>
	<script src="../assets/js/form-validation.js"></script>
</body>
</html>
