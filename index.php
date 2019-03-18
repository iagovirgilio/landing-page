<?php
    header('Content-Type: text/html; charset=utf-8');
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\PHPMailer;

    require 'node_modules/PHPMailer/src/Exception.php';
    require 'node_modules/PHPMailer/src/PHPMailer.php';
    require 'node_modules/PHPMailer/src/SMTP.php';

    $response = $_POST["g-recaptcha-response"];
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
       'secret' => '6LfsGZEUAAAAAC5ZF45T2-uhPFplgyL7-0g_g4fq',
       'response' => $_POST["g-recaptcha-response"]
    );
    $options = array(
       'http' => array (
       'method' => 'POST',
       'content' => http_build_query($data)
       )
    );
    $context  = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success=json_decode($verify);
    if ($captcha_success->success==true) {
       if (isset($_REQUEST['email'])) {
           $nome = $_REQUEST['nome'];
           $email = $_REQUEST['email'];
           $telefone = $_REQUEST['telefone'];
           $cidade = $_REQUEST['cidade'];
           $observacao = $_REQUEST['observacao'];

           $mail = new PHPMailer(true); // Passing `true` enables exceptions
           try {
               //Server settings
               $mail->SMTPDebug = 0; // Enable verbose debug output
               $mail->isSMTP(); // Set mailer to use SMTP
               $mail->Host = 'server.example.com.br'; // Specify main and backup SMTP servers
               $mail->SMTPAuth = true; // Enable SMTP authentication
               $mail->Username = 'site@example.com.br'; // SMTP username
               $mail->Password = 'xxxxx'; // SMTP password
               $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
               $mail->Port = 465; // TCP port to connect to

               //Recipients
               $mail->setFrom($email, $nome);
               /* $mail->setFrom('site@example.com.br', 'example Site Mailer'); */
               $mail->addAddress('example@example.com.br', 'Nome example'); // Add a recipient
               $mail->addReplyTo('example@example.com.br', 'Nome example');
               /* $mail->addCC('cc@example.com'); */
               $mail->addBCC('example@example.com.br', 'Nome example');

               //Attachments
               /* $mail->addAttachment('/var/tmp/file.tar.gz'); */// Add attachments
               /* $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); */// Optional name

               //Content
               $mail->isHTML(true); // Set email format to HTML
               $mail->CharSet = 'UTF-8';
               $mail->Subject = 'Formulário de contato';
               $mail->Body = "<font size='2' face='arial'>";
               $mail->Body .= "<strong>Formulário de Contato - landing-page</strong><br /><br />";
               $mail->Body .= "<strong>Nome:</strong> $nome<br />";
               $mail->Body .= "<strong>Telefone:</strong> $telefone<br /><br />";
               $mail->Body .= "<strong>Email:</strong> $email<br /><br />";
               $mail->Body .= "<strong>Cidade:</strong> $cidade<br /><br />";
               $mail->Body .= "<strong>Observação:</strong> $observacao<br />";
               $mail->Body .= "</font>";
               $mail->AltBody = strip_tags($mail->Body);

               if ($mail->send()) {
                   echo '<script>
                    window.alert("Mensagem enviada! Entraremos em contato em breve.");
                </script>';
               }
           } catch (Exception $e) {
               echo 'A mensagem não pode ser enviada. Mailer Error: ', $mail->ErrorInfo;
           }
       }
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Iago Virgílio">
    <meta name="keywords"
        content="sistema emissão nota fiscal, emissão nota fiscal, sistema, emissão, nota fiscal, nfe, nfce, autônomo, mei, online, rápido, fácil">
    <meta name="description"
        content="Prático NF-e é um sistema para emissão de Nota Fiscal eletrônica que ajuda autônomos e MEI's na compra e venda de produtos e serviços de forma simples e rápida">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="assets/images/favicon.png" rel="icon" sizes="32x32" type="image/png">
    <link rel="stylesheet" href="node_modules/bootstrap-4.3.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <title>Prático NFe - Emissão de Nota Fiscal eletrônica de forma simples e rápida!</title>

    <script src='https://www.google.com/recaptcha/api.js'></script>

    <script>
        (function(i,s,o,g,r,a,m){
        i['GoogleAnalyticsObject']=r;
        i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},
        i[r].l=1*new Date();
        a=s.createElement(o),m=s.getElementsByTagName(o)[0];
        a.async=1;
        a.src=g;
        m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-131131312-2', 'auto');
        ga('send', 'pageview');
    </script>
</head>

<body>

    <header>
        <div class="container-fluid fixed-top">
            <div class="row bg-header">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <nav class="navbar navbar-expand-lg">
                                <a class="navbar-brand" href="#">
                                    <img src="assets/images/praticonfe.svg" alt="">
                                </a>
                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span><i class="fas fa-bars"></i>
                                </button>

                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="navbar-nav mr-auto">
                                        <li class="nav-item active">
                                            <a class="nav-link" href="#functions">FUNCIONALIDADES <span
                                                    class="sr-only">(current)</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#contact">SAIBA MAIS</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" target="_blank"
                                                href="https://praticonfe.com.br/#planos">PLANOS</a>
                                        </li>
                                    </ul>
                                </div>

                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="banner bg-phone">
        <div class="container-fluid">
            <div class="row">
                <div class="container">
                    <div class="row">

                        <div class="col-12 col-sm-5 d-flex justify-content-center align-items-center">

                            <div class="col-12 bg-form">
                                <form action="" method="POST" class="mt-3">
                                    <div class="col-12 text-center">
                                        <h3>SAIBA MAIS</h3>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <input required type="text" name="nome" class="form-control" id="inputNome"
                                                placeholder="Nome" autofocus>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input required type="email" name="email" class="form-control"
                                                id="inputEmail" placeholder="Email">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input required type="text" name="telefone" class="form-control"
                                                id="inputTelefone" placeholder="Telefone">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input required type="text" name="cidade" class="form-control"
                                                id="inputCidade" placeholder="Cidade">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <textarea rows="4" name="observacao" class="form-control" id="inputObs"
                                                placeholder="OBSERVAÇÃO"></textarea>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="g-recaptcha"
                                                data-sitekey="6LfsGZEUAAAAAOFy_0A8xldnkxX5gVDtsv-o33fT"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 text-center">
                                        <button type="submit" class="btn btn-success">ENVIAR</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div
                            class="col-12 col-sm-7 order-sm-first d-flex flex-column justify-content-center align-items-center justify-content-sm-start align-items-sm-start">
                            <h2 class="title-banner">FAÇA EMISSÃO DE NOTAS FISCAIS</h2>
                            <p class="text-banner">
                                Intuitivo, prático e fácil de usar.
                                O Prático NFe veio para facilitar
                                o dia a dia do seu negócio
                            </p>
                            <a href="https://praticonfe.com.br/" target="_blank"
                                class="btn-lg btn-success bt-teste">FAÇA UM TESTE GRÁTIS</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="functions">
        <div class="container-fluid">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h3 class="title-pa">FUNCIONALIDADES</h3>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex flex-row fun-item">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <div>
                                    <h4>NOTAS FISCAIS</h4>
                                    <p>Emita notas fiscais de forma
                                        descomplicada, e preencha o setup
                                        inicial apenas uma vez
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex flex-row fun-item">
                                <i class="fas fa-file-export"></i>
                                <div>
                                    <h4>EXPORTAÇÃO DE XML</h4>
                                    <p>Exporte os arquivos XML das notas
                                        fiscais sem custo adicional
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex">
                                <i class="fas fa-chart-pie"></i>
                                <div>
                                    <h4>GRÁFICOS</h4>
                                    <p>Acompanhe no dashboard os gráficos
                                        com os resumos sobre as entradas e
                                        saídas
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex flex-row fun-item">
                                <i class="fas fa-file-signature"></i>
                                <div>
                                    <h4>CADASTROS</h4>
                                    <p>Cadastre usuários, clientes,
                                        fornecedores e transportadoras, e
                                        organize seu empreendimento.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex">
                                <i class="fas fa-cloud"></i>
                                <div>
                                    <h4>TOTALMENTE ONLINE</h4>
                                    <p>Trabalhe de onde quiser e quando
                                        quiser. Basta ter acesso à internet para
                                        emitir suas NFs.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex">
                                <i class="fas fa-align-justify"></i>
                                <div>
                                    <h4>BACKUP AUTOMÁTICO</h4>
                                    <p>Backup automático, ilimitado e gratuito.
                                        Suas notas em segurança por até 5 anos.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- <section id="contact" class="bg-contact">
        <div class="container-fluid">
            <div class="row">
                <div class="container">
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <footer class="bg-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-6 d-flex justify-content-center justify-content-sm-start">
                            <figure class="d-flex justify-content-center align-items-center justify-content-sm-start">
                                <img src="assets/images/praticonfe.svg" alt="">
                            </figure>
                        </div>

                        <div
                            class="col-12 col-sm-6 d-flex justify-content-center align-items-center justify-content-sm-end">
                            <a href="https://www.facebook.com/praticonfe/" target="_blank" class="social-item">
                                <i class="fab fa-facebook-square"></i>
                            </a>
                            <a href="https://www.instagram.com/" target="_blank" class="social-item">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="assets/js/jquery-3.3.1.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="node_modules/bootstrap-4.3.0-dist/js/bootstrap.js"></script>
</body>

</html>