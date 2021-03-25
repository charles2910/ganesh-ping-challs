<html>
<head>
	<title> Monitoring Tool </title>
    <style>
        body {
            background-color: rgba(0, 0, 0, 0.85);
            font-family: Arial, Helvetica, sans-serif;
            color: rgb(117, 117, 117);
        }

        .container {
            padding: 10px 5px 20px;
            background-color:rgba(53, 0, 122, 0.7);
            text-align: center;
            margin: auto;
            max-width: 570px;
            border-radius: 10px;
            border: 1px solid rgb(117, 117, 117);
        }

        .inputDescription {
            font-size: 18px;
        }

        a {
            text-decoration: none;
            font-weight: bold;
            font-size: 15px;
            color: white;
            transition-duration: 0.2s;
        }

        a:hover {
            transition-duration: 0.2s;
            color: rgb(117, 117, 117);
            font-size: 110%;
        }
    </style>
	<script>
        function check() {
            ip = document.getElementById("ip").value;
            chk = ip.match(/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/);
            if (!chk) {
                alert("Wrong IP format.");
                return false;
            } else {
                document.getElementById("monitor").submit();
            }
        }
	</script>
</head>
<body>
    <div class="container">
        <h1> Monitoring Tool ver 0.2 </h1>
        <form id="monitor" action="index.php" method="post" onsubmit="return false;">
            <p class="inputDescription"> Input IP address of the target host: <input id="ip" name="ip" type="text"> </p>
            <input type="button" value="Go!" onclick="check()">
        </form>

        <?php
            $ip = $_POST["ip"];
            if ($ip) {
                // super fancy regex check!
                if (preg_match('/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])/',$ip)) {
                    exec('ping -c 1 ' . $ip, $cmd_result);
                    foreach($cmd_result as $str){
                        if (strpos($str, '100% packet loss') !== false) {
                            printf("<h3>Target is NOT alive.</h3>");
                            break;
                        } else if (strpos($str, ', 0% packet loss') !== false){
                            printf("<h3>Target is alive.</h3>");
                            break;
                        }
                    }
                } else {
                    echo "Wrong IP Format.";
                }
            }
        ?>

        <a href="index.txt"> Source code here! </a>
    </div>
</body>
</html>
