<?php
require_once 'Book.php';
require_once 'Library.php';

$conn = mysqli_connect("localhost","root","","books");



session_start();

// Create a Library instance or get it from the session
$library = isset($_SESSION['library']) ? $_SESSION['library'] : new Library();

// Check if the form is submitted for adding a book
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_book'])) {
    $id = uniqid(); // Generate a unique ID for the book
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $coverUrl = $_POST['cover_url'];

    // Create a new Book instance and add it to the library
    $newBook = new Book($id, $title, $author, $isbn, $coverUrl);
    $library->addBook($newBook);

    // Save the library to the session
    $_SESSION['library'] = $library;


    $uQuery = "INSERT INTO `newbook`(`title`,`author`,`isbn`,`cover`)
    VALUES ('$title','$author','$isbn','$coverUrl')";
    $result = mysqli_query($conn ,$uQuery);

    if($result){
        echo '
            <script>
                alert("book add Successful");
            </script>
        ';
    }
    else{
        echo '
            <script>
                alert("Registration Failed");
            </script>
        ';
    }

}

// Check if the form is submitted for deleting a book
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_book'])) {
    $bookIdToDelete = $_POST['book_id'];
    $library->deleteBook($bookIdToDelete);

    // Save the library to the session
    $_SESSION['library'] = $library;
}

// Display the list of books in the library
$booksInLibrary = $library->getBooks();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Library</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-image: url('bg.jpg');
        }

        h2 {
            color: black;
            font-family: 'Dancing Script', cursive;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="url"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0 20px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"],
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #45a049;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            display: flex;
            justify-content: space-between;
        }

        img {
            max-width: 100px;
            max-height: 150px;
        }

        button.delete {
            background-color: #f44336;
        }

        button.delete:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <h2><center>Digital Library</center></h2>

    <!-- Form for adding a book -->
    <form method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="author">Author:</label>
        <input type="text" id="author" name="author" required>

        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" required>

        <label for="cover_url">Cover URL:</label>
        <input type="url" id="cover_url" name="cover_url" required>

        <input type="submit" name="add_book" value="Add Book">
    </form>

    <?php
    // Display the list of books in the library
    if (!empty($booksInLibrary)) {
        echo "<ul>";
        foreach ($booksInLibrary as $book) {
            echo "<li>";
            echo "<div>";
            echo "<h3>{$book->title}</h3>";
            echo "<p>Author: {$book->author}</p>";
            echo "<p>ISBN: {$book->isbn}</p>";
            echo "</div>";
            echo "<img src='{$book->coverUrl}' alt='{$book->title} cover'>";
            echo "<div>";
            echo "<form method='post' style='margin-top: 10px;'>";
            echo "<input type='hidden' name='book_id' value='{$book->id}'>";
            echo "<button class='delete' type='submit' name='delete_book'>Delete</button>";
            echo "</form>";
            echo "</div>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No books in the library yet.</p>";
    }
    ?>
</body>
</html>
