<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Registrar </title>
    <!-- plugins:css -->
    <?php include 'partials/headtags.php'; ?>

    <style>
        body {
            background-color: #f3f3f4;
        }

        .img-size {
            width: 120px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div class="">

                <img src="./images/Controll10.png" class="img-circle img-size" />

            </div>
            <h3>Registrar no Controle de Clientes e Produtos</h3>
            <p>Crie uma nova conta para iniciar a sessão.</p>
            <form class="m-t" role="form" autocomplete="off" action="php/registerClient.php" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Name" required name="Name" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" required name="Email" required>
                </div>
                <div class="form-group">
                    <select name="Role" class="form-control" id="Role" required>
                        <option value=""> Cargo </option>
                        <option value="0" name="Role">Suporte</option>
                        <option value="1" name="Role">Vendedor</option>
                        <option value="2" name="Role">Gerente</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="Password" minlength="8"
                        required>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Register</button>
            </form>
            <p class="m-t"> <small>Controlle 10</small> </p>
        </div>
    </div>
    <!-- container-scroller -->
    <?php include 'partials/javascripts.php'; ?>

</body>

</html>