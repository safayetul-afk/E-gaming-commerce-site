<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Register a Game</h1>
    <form method="post" action="{{ route('games.store') }}">
        @csrf
        @method('post')
        <div>
            <label>Name:</label>
            <input type="text" name="name" placeholder="Name">
        </div>
        <div>
            <label>Price:</label>
            <input type="text" name="price" placeholder="Price">
        </div>
        <div>
            <label>Rating:</label>
            <input type="text" name="rating" placeholder="Rating">
        </div>
        <div>
            <label>Description:</label>
            <input type="text" name="description" placeholder="Description">
        </div>
        <div>
            <input type="submit" value="Register a New Game">
        </div>
    </form>
</body>
</html>