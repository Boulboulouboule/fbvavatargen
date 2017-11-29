<!DOCTYPE html>
<html>
<head>
    <title>Facebook Login</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="node_modules/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php $filname = date('YmdHis'); ?>
<script>
    // This is called with the results from from FB.getLoginStatus().
    function statusChangeCallback(response) {
        if (response.status === 'connected') {
            testAPI();
        } else {
            document.getElementById('status').innerHTML =
                `<div class="lead alert alert-warning">
					Vous devez vous connecter à facebook
					<br/>
				</div>`;
        }
    }

    function checkLoginState() {
        FB.getLoginStatus(function (response) {
            statusChangeCallback(response);
        });
    }

    window.fbAsyncInit = function () {
        FB.init({
            appId: '131023097573160',
            cookie: true,
            xfbml: true,
            version: 'v2.11'
        });

//        FB.getLoginStatus(function (response) {
//            statusChangeCallback(response);
//        });

    };

    (function (d, s, id) {
        let js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function testAPI() {
        FB.api('/me', function (response) {
            let requestBody = {
                name:response.name,
                file: <?php echo $filname; ?>
            };
            fetch("/imgGen.php?name=" + response.name + "&file=<?php echo $filname; ?>", {
                headers: {"Content-Type": "application/json"},
                method: "GET",
//                body: JSON.stringify(requestBody)
            })
                .then(function () {
                    document.getElementById('status').innerHTML =
                        `<div class="lead alert alert-success">
							Merci ${response.name}, une image à votre nom vient d'être générée
							<br/>
							<img src='avatars/<?php echo $filname; ?>.jpg' />
						</div>`;
                })
                .then(function(){
                    fetch('/merge.php?name=" + response.name + "&file=<?php echo $filname; ?>', {
                        headers: {"Content-Type": "application/json"},
                        method: "GET",
                    })
                })
        });
    }
</script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->


<div class="container text-center">
    <div id="status"></div>
    <div class="jumbotron">
        <p class="lead">Connectez vous à facebook pour générer une image à votre nom!</p>
        <button class="btn btn-primary" onclick="checkLoginState()"><span class="fa fa-facebook"></span> Connexion à mon compte
            facebook
        </button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
        integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
        integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
        crossorigin="anonymous"></script>
</body>
</html>