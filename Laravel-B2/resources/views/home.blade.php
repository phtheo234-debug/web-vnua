<html>
<body>
    @if(session('form'))
        <h1>from {{ session{'from'} }}</h1>
    @endif

    <form action="/home/search" method="post">
        text: <input type="text" name="search"><br>
        <input type="submit">
    </form>
</body>
</html>