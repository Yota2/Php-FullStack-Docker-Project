<?php
$connect = mysqli_connect('db', 'php_docker', 'password', 'php_docker');
$table_name = "php_docker_table";

// Check if form is submitted for Update/Delete/Create
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        // Delete operation
        $id = $_POST['id'];
        $query = "DELETE FROM $table_name WHERE id=$id";
        mysqli_query($connect, $query);
    } elseif (isset($_POST['save'])) {
        // Save operation (Update or Create)
        $id = $_POST['id'];
        $title = $_POST['title'];
        $body = $_POST['body'];
        if (!empty($id)) {
            // Update existing
            $query = "UPDATE $table_name SET title='$title', body='$body' WHERE id=$id";
        } else {
            // Create new
            $query = "INSERT INTO $table_name (title, body, date_created) VALUES ('$title', '$body', NOW())";
        }
        mysqli_query($connect, $query);
    }
}

// Fetch all posts to display
$query = "SELECT * FROM $table_name";
$response = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP CRUD</title>
    <script>
        function setUpdateForm(id, title, body) {
            document.getElementById('id').value = id;
            document.getElementById('title').value = title;
            document.getElementById('body').value = body;
        }

        function setCreateForm() {
            document.getElementById('id').value = '';
            document.getElementById('title').value = '';
            document.getElementById('body').value = '';
        }
    </script>
</head>
<body>

<?php
echo "<strong>$table_name: </strong>";
while($i = mysqli_fetch_assoc($response)) {
    echo "<p>".$i['title']."</p>";
    echo "<p>".$i['body']."</p>";
    echo "<p>".$i['date_created']."</p>";
    // Update and Delete buttons
    echo "<button onclick=\"setUpdateForm('".$i['id']."', '".$i['title']."', '".$i['body']."')\">Update</button>";
    echo "<form style='display:inline;' method='post'><input type='hidden' name='id' value='".$i['id']."'><input type='submit' name='delete' value='Delete'></form>";
    echo "<hr>";
}
?>

<!-- Form for creating/updating -->
<form method="post">
    <input type="hidden" name="id" id="id">
    <input type="text" name="title" id="title" placeholder="Title">
    <textarea name="body" id="body" placeholder="Body"></textarea>
    <input type="submit" name="save" value="Save">
</form>
<br>
<button onclick="setCreateForm()">Clear form</button>

</body>
</html>