<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{asset('css/bootstrap.min.css') }}" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>AgroLivre</title>
</head>
<body class="text-center">
    @error('email')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 relative" role="alert">
            <strong class="font-bold">Erro!</strong>
            <span class="block sm:inline">{{ $message }}</span>
        </div>
    @enderror
    <main class="form-signin">
        <form action="{{ route('login.auth') }}" method="POST">
            @csrf
            <img class="mb-4 logo" src="images/logo.svg" alt="" >

            <div class="form-floating">
                <input type="email" class="form-control" name="email" id="email" placeholder="email">
                <label for="floatingInput">Email</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" name="password" id="password" placeholder="senha">
                <label for="floatingPassword">Senha</label>
            </div>

            <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="Lembrar"> Lembrar-me
            </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>
        </form>
    </main>
    </body>
</body>
</html>