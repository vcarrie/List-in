<form action="/public/auth/login" method="post">
    {{ csrf_field() }}

    {{ $auth }}
    <input type="text" name="mail"> <br>
    <input type="password" name="password"><br>
    <input type="submit" value="connexion">
</form>
<br>
<a href="/public/auth/register">S'inscrire</a>