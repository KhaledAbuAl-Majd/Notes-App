<?php
require_once 'config.php';
session_start();

//check if session is not exist : transform it to login page to login again
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

//add or update note
if (isset($_POST['save_note'])) {
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $note_id = $_POST['note_id']; // هيكون فاضي لو إضافة، وفيه قيمة لو تعديل

    if (!empty($content)) {
        if (!empty($note_id)) {
            // (Update)
            $sql = "UPDATE Notes SET Content = '$content' WHERE NoteID = $note_id AND UserID = $user_id";
        } else {
            //(Insert)
            $sql = "INSERT INTO Notes (Content, UserID) VALUES ('$content', '$user_id')";
        }
        mysqli_query($conn, $sql);
    }
    header("Location: index.php");
    exit();
}

//delete note
if (isset($_GET['delete'])) {
    $note_id = intval($_GET['delete']);
    $sql = "DELETE FROM Notes WHERE NoteID = $note_id AND UserID = $user_id";
    mysqli_query($conn, $sql);
    header("Location: index.php");
}

// get notes
$sql = "SELECT * FROM Notes WHERE UserID = $user_id ORDER BY NoteID DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
    
    .note-card { 
        cursor: pointer; 
        border-radius: 12px; 
        border: none; 
        transition: 0.3s;
        overflow: hidden;
    }
    
    .note-card:hover { transform: translateY(-3px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }

    .note-content-preview {
        display: -webkit-box;
        -webkit-line-clamp: 2; /*two lines only*/
        -webkit-box-orient: vertical;  
        overflow: hidden;
        text-overflow: ellipsis;
        
        word-break: break-all;
        overflow-wrap: break-word; 
        
        flex: 1; 
    }

    .delete-btn {
        min-width: 70px;
        z-index: 10;
    }
</style>
</head>
<body>

<nav class="navbar navbar-dark bg-primary mb-4 shadow-sm">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Notes App</span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm p-3 mb-5">
                <h5 id="form-title">Add New Note</h5>
                <form method="POST">
                    <input type="hidden" name="note_id" id="note_id">
                    
                    <textarea name="content" id="note_text" class="form-control mb-2" rows="4" placeholder="Write or edit your note here..." required></textarea>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" name="save_note" class="btn btn-primary flex-grow-1">Save Note</button>
                        <button type="button" id="cancel-btn" class="btn btn-secondary" style="display:none;" onclick="resetForm()">Cancel</button>
                    </div>
                </form>
            </div>

            <h4 class="mb-3">Your Notes</h4>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="card note-card mb-3 shadow-sm" onclick="editNote(<?php echo $row['NoteID']; ?>, `<?php echo addslashes($row['Content']); ?>`)">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div style="flex: 1;">
                            <p class="note-content-preview mb-0 text-dark"><?php echo htmlspecialchars($row['Content']); ?></p>
                        </div>
                        <div class="ms-3">
                            <!-- sending note id to current card to delete - get method -->
                            <a href="index.php?delete=<?php echo $row['NoteID']; ?>" class="btn btn-sm btn-outline-danger" onclick="event.stopPropagation();
                             return confirm('Delete this note?')">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<script>
    function editNote(id, content) {
        document.getElementById('note_id').value = id;
        document.getElementById('note_text').value = content;
        document.getElementById('form-title').innerText = "Edit Note";
        document.getElementById('cancel-btn').style.display = "block";
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
        document.getElementById('note_text').focus();
    }

    function resetForm() {
        document.getElementById('note_id').value = "";
        document.getElementById('note_text').value = "";
        document.getElementById('form-title').innerText = "Add New Note";
        document.getElementById('cancel-btn').style.display = "none";
    }
</script>

</body>
</html>