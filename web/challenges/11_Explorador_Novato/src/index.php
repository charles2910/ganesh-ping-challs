<html>
    <head>
        <title> 1, 2, 3, 4, 5... </title> 
        <style>
            body {
                margin: 0;
                padding: 0;
                background-color: black;
                color: white;
            }

            h1, h3 {
                text-align: center;
            }

            p {
                width: 800px;
                margin: 20px auto;
            }

            td {
                border: 1px solid white;
                text-align: center;
                padding: 5px 20px;
                width: 400px;
            }

            .footer {
                display: flex;
                justify-content: center;
                align-itens: center;
                flex-direction: row;
                position: fixed;
                left: 0;
                bottom: 0;
                padding: 10px;
                border: 2px solid #80ff8c;
                border-radius: 10px 0;
                width: 100%;
                background-color: #a8a8a8;
                color: white;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <h1> Picos mais altos do Brasil </h1>
        <h3> Breve descrição da página </h3>
        <p>
            Nam lobortis varius tortor accumsan sollicitudin. Ut venenatis, libero non consequat varius, dolor justo eleifend turpis, ac iaculis justo purus in libero. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus eu turpis quis urna tempor mollis. Etiam pretium euismod maximus. Fusce ultricies tincidunt vestibulum. Vestibulum vitae varius dolor, vitae mollis nisl. Ut finibus ipsum nec justo sollicitudin, eget fringilla purus ornare. Donec vulputate leo arcu, sit amet tincidunt ipsum commodo dignissim. Sed a leo blandit, dapibus sapien a, convallis ante. Pellentesque id elit mauris. Sed a mi rutrum, vulputate arcu non, placerat arcu. Donec nec semper nulla.
        </p>
        <p>
            Cras elementum felis nec finibus efficitur. Ut eros urna, elementum id risus et, varius blandit est. Proin ultrices semper ultrices. Aliquam ac elementum lectus, ac blandit lorem. Sed euismod urna ut est feugiat tempus. Sed id tincidunt urna, sit amet congue purus. Vestibulum finibus malesuada magna quis faucibus. Proin quis lobortis ante. Vestibulum rhoncus magna dolor, sed porta felis dignissim sit amet.
        </p>
        <p>
            Nunc porttitor a risus varius condimentum. Nunc ac quam sit amet magna luctus semper vitae sed lectus. Vestibulum tempor eros eu odio venenatis bibendum. Aliquam tincidunt imperdiet velit, non blandit odio euismod at. Sed ac fringilla nunc. Donec vel velit quis nisi dapibus pharetra vitae non metus. In eget orci dolor.
        </p>
        <table align="center">
            <?php
                $flag = "Ganesh{XPl0r3_ThE_W!Ld}";
                $directory = "./images";
                $images = glob($directory . "/*.jpg");
                $special_source = rand(0, 5);
                $i = 0;

                foreach($images as $image)
                {
                    echo "<tr><td>";
                    if ($i == $special_source) {
                        echo "<img width=600px src=" . $image . " alt=" . $flag . " />";
                    }
                    else {
                        echo "<img width=600px src=" . $image . " alt='Nothing to write here' />";
                    }
                    echo "</td><td>";
                    echo "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet euismod fringilla. Fusce consectetur, lacus et maximus congue, lacus nisl pharetra erat, nec tincidunt nunc nulla a elit. Integer ante odio, blandit ut sapien non, iaculis tempor arcu. Praesent consectetur at massa vehicula varius. Donec suscipit libero id ligula fringilla convallis. Phasellus dapibus dapibus congue. Donec sit amet orci in neque viverra bibendum non et urna. In aliquet pharetra odio, et bibendum nibh molestie id.";
                    echo "</td></tr>";
                    $i += 1;
                }
            ?>
         </table>
         <div class="footer">
            <img src="./images/ganeshLogo.png" alt="Logo do Ganesh" width="50px"/>
            <h2 style="margin-left: 10px;"> Made by Guerra - Ganesh 2020 </h2>
        </div>
    </body>
</html>