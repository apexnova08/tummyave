<!DOCTYPE html>
<html>
<head>
    <title>PHP File Uploads</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">    
</head>
<body>

<h1>PHP File Uploads</h1>

<form method="post" enctype="multipart/form-data" action="processes/process.php">

    <!-- <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> -->

    <label for="image">Image file</label>
    <input type="file" id="image" name="image">

    <label for="file2">Another file</label>
    <input type="file" name="file2" id="file2">

    <button>Upload</button>

</form>

</body>
</html>