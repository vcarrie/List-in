<form action="/public/auth/register" method="post">
    {{ csrf_field() }}
    Pseudo <input type="text" name="pseudo"> <br>
    Prénom <input type="text" name="firstName"> <br>
    Nom<input type="text" name="lastName"> <br>
    Mail<input type="text" name="email"> <br>
    Mot de passe <input type="password" name="password"> <br>
    <input type="submit" value="m'inscrire"><br>
</form>
<br>
<a href="/public/auth/login">Retour</a>