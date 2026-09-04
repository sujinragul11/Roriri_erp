<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");

$trainerRoles = [1, 2, 3, 4, 5, 6, 7, 8, 9, 12, 13, 14, 15, 16]; // Define the roles for trainers

if (in_array($_SESSION['role'], $trainerRoles)) {
    // Query for trainers
    $selQuery = "SELECT a.*, a.intern_id AS intern, b.* FROM internship_tbl AS a LEFT JOIN intern_support_tbl AS b ON a.intern_id = b.intern_id WHERE a.status = 'Active' AND a.incharge_id = {$_SESSION['id']} GROUP BY a.intern_id ORDER BY MAX(b.date_time) DESC";
} else {
    // Query for admins
    $selQuery = "SELECT a.*, a.intern_id AS intern, b.* FROM internship_tbl AS a LEFT JOIN intern_support_tbl AS b ON a.intern_id = b.intern_id WHERE a.status = 'Active' GROUP BY a.intern_id ORDER BY MAX(b.date_time) DESC";
}  

$resQuery = mysqli_query($conn , $selQuery); 

// Fetch unread messages for interns
$unreadQuery = "
    SELECT DISTINCT intern_id 
    FROM intern_support_tbl 
    WHERE msg_status = 'Unread' 
    AND reply_id = 0 AND status = 'Active'";
$unreadResult = mysqli_query($conn, $unreadQuery);

// Build an array of interns with unread messages
$unreadInterns = [];
while ($unreadRow = mysqli_fetch_assoc($unreadResult)) {
    $unreadInterns[] = $unreadRow['intern_id'];
}
?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
<style>
        .error-message {
            color: red;
            display: none;
        }
        .error {
            border-color: red;
        }
    </style>
	<!--wrapper-->
	<div class="page-wrapper">
	    <?php include("internshipLeft.php");?>
	    <?php include("top.php");?>
			<div class="page-content">
				<div class="chat-wrapper">
					<div class="chat-sidebar">
						<div class="chat-sidebar-header">
							<div class="d-flex align-items-center">
								<div class="chat-user-online">
								    <?php 
                                    $username = $_SESSION['username'];
                                    $imagePathPng = $imageView . $username . ".png";
                                    
                                    // Checking if the file exists on a remote server
                                    $headers = @get_headers($imagePathPng);
                                    
                                    if($headers && strpos($headers[0], '200')) {
                                        // If the file exists, use the user image
                                        $userImage = $imagePathPng;
                                    } else {
                                        // If the file doesn't exist, use the default image
                                        $userImage = $default_image;
                                    }
                                    ?>
									<img src="<?php echo $userImage; ?>" width="45" height="45" class="rounded-circle" alt="" />
								</div>
								<div class="flex-grow-1 ms-2">
									<p class="mb-0"><?php   echo $_SESSION['name'];  ?></p> 
								</div>
							</div>
							<div class="mb-3"></div>
							<div class="input-group input-group-sm"> <span class="input-group-text bg-transparent"><i class='bx bx-search'></i></span>
								<input type="text" id="searchBox" class="form-control" placeholder="People, groups, & messages"> 
							</div>
						</div>
						<div class="chat-sidebar-content">
							<div class="tab-content" id="pills-tabContent">
								<div class="tab-pane fade show active" id="pills-Chats"> 
									<div class="chat-list" style="height:500px; overflow-y:auto;">
										<div class="list-group list-group-flush">
										    <?php $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                           
                                                                $intern_id  = $row['intern'];  
                                                                $name       = $row['name'];   
                                                                $image      = !empty($row['image']) ? "https://asset.inforiya.in/ERP/ERP_image/Intern/{$row['image']}" : "https://asset.inforiya.in//ERP/ERP_image//Employee//download.png"; 
                                                                $hasUnread  = in_array($intern_id, $unreadInterns);
                                              ?>
											<a href="javascript:;" class="list-group-item" data-intern-id="<?php echo $intern_id; ?>" data-intern-name="<?php echo $name; ?>">
												<div class="d-flex align-items-center">
														<img src="<?php echo $image; ?>" width="42" height="42" class="rounded-circle" alt="" />
														<h6 class="mb-0 chat-title ms-3"><?php echo $name; ?></h6>
														<?php if ($hasUnread) { ?>
                                                            <span class="badge bg-danger ms-2">Unread</span>
                                                        <?php } ?>
												</div>
											</a>
											<?php } ?> 
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="chat-header d-flex align-items-center">
						<div class="chat-toggle-btn"><i class='bx bx-menu-alt-left'></i>
						</div>
						<div>
							<h4 class="mb-1 font-weight-bold" id="internName"></h4>
						</div>
					</div>
					<div class="chat-content"></div>
					<div class="chat-footer d-flex align-items-center">
                        <form id="chat-form" class="flex-grow-1 pe-2 needs-validation" novalidate>
                            <input type="hidden" class="form-control" id="internId" name="internId"> 
                            <div class="input-group">
                                <input type="text" class="form-control" id="chatInput" name="chatInput" placeholder="Type a message" required>
                                <div class="chat-footer-menu ms-2"> <!-- Add margin to the button container -->
                                    <button type="submit" class="btn btn-primary">
                                        <i class='bx bx-paper-plane'></i> <!-- WhatsApp-like send icon -->
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
					<!--start chat overlay-->
					<div class="overlay chat-toggle-btn-mobile"></div>
					<!--end chat overlay-->
				</div>
			</div>
		</div>
	<!--end wrapper-->

	<!--start switcher-->

	<!--end switcher-->
	<!-- Bootstrap JS -->
	<!-- Bootstrap JS -->
	<script src="<?php echo $bootsrapBundle; ?>"></script>
	<!--plugins-->
	<script src="<?php echo $js; ?>"></script>
	<script src="<?php echo $simplebar;?>"></script>
	<script src="<?php echo $mentimenu; ?>"></script>
	<script src="<?php echo $perfectScrolbar;  ?>"></script>
	<script src="<?php echo $datatableMin; ?>"></script>
	<script src="<?php echo $datatbaleBootstrap;?>"></script>
     <!-- Include Bootstrap JS (with Popper) -->
    <script src="<?php echo $popper;?>"></script>
    <script src="<?php echo $bootStackPath;?>"></script>
	<script src="<?php echo $sweetalert; ?>"></script>
    <!-- Include the function.js -->
    <script src="../assets/js/function.js"></script>
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
		<script src="../assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script>
		new PerfectScrollbar('.chat-list');
		new PerfectScrollbar('.chat-content');
	</script>
<script>
$(document).ready(function() {
    $('.list-group-item').on('click', function() {
        $('.list-group-item').removeClass('active');
        $(this).addClass('active');
        var internId = $(this).data('intern-id');
        var internName = $(this).data('intern-name');
        $('#internName').text(internName);
        $('#internId').val(internId);
        $(this).find('.badge.bg-danger.ms-2').remove();
        
        if ($('.list-group-item .badge.bg-danger.ms-2').length === 0) {
            // Remove badge from the "Support" menu if none remain
            $('.menu-title:contains("Support")').find('.badge').remove();
        }
        // Make an AJAX request to fetch messages
        $.ajax({
            url: 'action/actSupport.php', // Update with your file path
            type: 'GET',
            data: { intern_id: internId }, 
            dataType: 'json',
            success: function(response) {
                var messages = response; 
                var lastDate = ''; 
            
                $('.chat-content').empty();
            
                messages.forEach(function(message, index) {
                    var messageDate = new Date(message.date_time).toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    });
                    var messageTime = new Date(message.date_time).toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
            
                    if (messageDate !== lastDate || index === 0) {
                        lastDate = messageDate; 
                        var dateHeader = `
                            <div class="chat-date-header text-center text-gray-500 my-2">
                                <span class="px-4 py-2 bg-gray-200 rounded">${messageDate}</span>
                            </div>
                        `;
                        $('.chat-content').append(dateHeader); 
                    }
            
                    var chatMessage;
                    if (message.reply_id == 0) {
                        chatMessage = `
                            <div class="chat-content-leftside">
                                <div class="d-flex">
                                    <img src="${message.user_image}" width="48" height="48" class="rounded-circle" alt="" />
                                    <div class="flex-grow-1 ms-2">
                                        <p class="mb-0 chat-left-msg">${message.msg}</p>
                                        <p class="mb-0 chat-time">${messageTime}</p>
                                    </div>
                                </div>
                            </div>`;
                    } else {
                        chatMessage = `
                            <div class="chat-content-rightside">
                                <div class="d-flex">
                                    <div class="flex-grow-1 me-2">
                                        <p class="mb-0 chat-right-msg">${message.msg}</p>
                                    </div>
                                    <img src="${message.admin_image}" width="48" height="48" class="rounded-circle" alt="" />
                                </div>
                                <p class="mb-0 chat-time text-end me-5">${message.empName}, ${messageTime}</p>
                            </div>`;
                    }
                    $('.chat-content').append(chatMessage);
                });
                $('.chat-content').scrollTop($('.chat-content')[0].scrollHeight);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
});

$(document).ready(function() {
    $('#chat-form').on('submit', function(event) {
        event.preventDefault(); // Prevent form from submitting the traditional way
        var formData = new FormData(this);
        var message = formData.get('chatInput');
        console.log('Message:', message);
        // Send AJAX request to save the message in the database
        $.ajax({
            url: 'action/actSupport.php', 
            method: 'POST',
            data: formData, 
            processData: false,  // Important for FormData
            contentType: false,  // Important for FormData
            dataType: 'json',
            success: function(response) {

                $('.chat-content').append(`
                    <div class="chat-content-rightside">
                        <div class="d-flex">
                            <div class="flex-grow-1 me-2">
                                <p class="mb-0 chat-right-msg">${message}</p>
                            </div>
                            <img src="https://asset.inforiya.in//ERP/ERP_image//Employee//download.png" width="48" height="48" class="rounded-circle" alt="" />
                        </div>
                        <p class="mb-0 chat-time text-end me-5">Just now</p>
                    </div>
                `);

                $('#chatInput').val('');

                $('.chat-content').scrollTop($('.chat-content')[0].scrollHeight);
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('There was an error sending the message.');
            }
        });
    });
});

</script>

<script>
    $(document).ready(function() {
        $('#searchBox').on('input', function() {
            var searchTerm = $(this).val().toLowerCase(); // Get the search term and convert to lowercase

            $('.list-group-item').each(function() {
                var chatTitle = $(this).find('.chat-title').text().toLowerCase(); // Get chat title text

                // Check if the chat title includes the search term
                if (chatTitle.includes(searchTerm)) {
                    $(this).show(); // Show the item if it matches
                } else {
                    $(this).hide(); // Hide the item if it doesn't match
                }
            });
        });
    });
</script>

<script src="../assets/js/form-validation.js"></script>
</body>
</html>