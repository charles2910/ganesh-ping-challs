<?php
$u_agent = $_SERVER['HTTP_USER_AGENT'];
$isbot = false;

// https://support.google.com/webmasters/answer/1061943?hl=en

if (strlen(strstr($u_agent, "Googlebot")) > 0) { // User-agent is Googlebot
    echo "
    <h1> Olá Googlebot! </h1> 
    <div style='text-align: center; border: 1px solid grey; border-radius: 5px; background-color: #a2fcf2; width: 600px; margin: auto;'>
        <h2> Aqui está sua flag: Ganesh{Cr4wl1nG_!n_My_w3b5ite} </h2>
    </div>
    ";
}
else {
    echo "<div style='text-align: center; border: 1px solid grey; border-radius: 5px; background-color: #ffc6b0; width: 400px; margin: auto;'> <h2> Você não é o Googlebot >:( </h2> </div>";
}

?>
