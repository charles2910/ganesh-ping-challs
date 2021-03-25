<html>
    <head>
        <title> O rato roeu a roupa do rei de Roma </title>
        <script src="defaultScript.js"></script>
        <style>
            body {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                background-color: black;
                color: white
            }
            .passwordForm {
                width: 600px;
                height: 130px;
                border: 2px solid rgb(214, 214, 214);
                border-radius: 10px;
                background-color: rgba(141, 245, 219, 0.452);
                margin: auto;
                justify-content: center;
                align-items: center;
                display: flex;
                flex-direction: column;
            }
    
            label, input, button {
                margin: 5px;
                font-size: 18px;
            }
    
            p {
                font-size:20px; 
                margin: 10px; 
                padding: 5px
            }
    
            img {
                width: 250px;
                height: 200px;
            }
        </style>
    </head>
    <body>
        <p>
            Salve meu querido/querida/queride. Aqui você pode trocar sua senha única de mentirinha por um ticket de mentirinha que não vale nada, olha que incrível! Mentira, na realidade ele vale uns pontos no CTF do Ping do Ganesh. É bem fácil então acho que vale a pena você tentar ganhar esses pontinhos. 
        </p>
        <p> 
            Eu só to escrevendo isso aqui para a página não ficar absurdamente vazia, sabe? Não sei mais o que escrever. A gente pode começar uma conversa, né? Pensa que é o Guerra (que está escrevendo isso nesse exato momento) falando com você: Tudo bom? Já resolveu esse chall? Não desiste meu bom, vai dar tudo certo. Desculpa por esse texto sem sentido e de nada pelo fundo escuro na página. Jesus te ama, beijo. #foco #nopainnogain #lifestyle #workhard #desafio #like4like #zumba #marcelobatata
        </p>
        <p>
            Olha esse gatinho aqui, é bem fofo: 
        </p>
        <img src="cuteImg.png" />

        <form class="passwordForm" method="post" action="?">
            <label for="pass"> Submit your password to get your entry ticket code: </label>
            <input type="text" id="pass" name="pass" placeholder="Insert password" />
            <input type="submit" value="SUBMIT" id="submitPassword" />
        </form>

        <?php
            /*
            subl /etc/hosts -> set new host to 127.0.0.1
            sudo mkdir /var/www/test -> create folder inside /var/www
            sudo chown -R $USER:$USER /var/www/test -> changing ownership of test folder to my user
            sudo chmod -R 755 /var/www
            sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/test.conf
            subl /etc/apache2/sites-available/test.conf -> edit configs
            sudo a2ensite test.conf -> apache to enabled site
            ln -s /var/www /home/haltz/Desktop/Ganesh_019-020\ \(1\)/2020/PING\ 2020/ -> create symlink to /var/www

            use ./virtualhost create server_name server_folder
            */

            if (isset($_POST['pass'])) {
                $userPassword = $_POST['pass'];

                if ($userPassword != 'strongpassword')
                    header("location: ?ticketFailed=true");
                else 
                    echo "<h2 style='text-align: center;'> Aqui está seu ticket de entrada: Ganesh{e@sy_3nc0nd!Ng} </h2>";
            }  

            if (isset($_GET["ticketFailed"])) {
                if ($_GET["ticketFailed"] == "true")
                    echo "<h2 style='text-align: center;'> Esse código não é válido, desculpe! </h2>";
            }
            
        ?>
        
    </body>
</html>