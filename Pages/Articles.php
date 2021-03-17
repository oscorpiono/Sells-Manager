<?php
    if(isset($_POST["submit"]))
    {
        $conn = mysqli_connect("localhost", "root", "", "gestiondevents");
        if($conn -> connect_error)
        {
            die("Connection failed:". $conn-> connect_error);
        }
        $Code = $_POST["CodeArt"];
        $Des = $_POST["Designation"];
        $Prix = $_POST["Prix"];
        $sql = "INSERT INTO `articles` (`Code`, `Designation`, `Prix`) VALUES ('$Code', '$Des', '$Prix');";
        $res = mysqli_query($conn, $sql);
        if($res == true)
        {
            echo "<script>alert('L article a ete insere avec success');  window.location.replace('http://' + window.location.hostname + '/Pages/Articles.php');</script>";
            header("Location: /Pages/Articles.php");
        }
        else
        {
            echo "<script>alert('Voulez vous verifier vos entres, quelque chose n est pas logic'); window.location.replace('http://' + window.location.hostname + '/Pages/Articles.php');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Des Ventes</title>
    <script src="/js/jquery.js"></script>
    <script src="/js/qrcode.js"></script>
    <link rel="stylesheet" href="/Styles/style.css">
    <link rel="shortcut icon" href="/Images/trade.png" />
</head>
<body style="overflow-y: auto;">
    <nav>
        <div class="TopSide">
            <div class="Title">
                <a href="/">Gestion Des Ventes</a>
            </div>
            <div class="Log">
                <a href="#" class="State">Login</a>
            </div>
        </div>
        <div class="BottomSide">
            <div class="NavLinks">
                <ul>
                    <li>
                        <a href="/Pages/Articles.html">Articles</a>
                    </li>
                    <li>
                        <a href="#">Clients</a>
                    </li>
                    <li>
                        <a href="#">Stock</a>
                    </li>
                    <li>
                        <a href="#">Commades</a>
                    </li>
                </ul>
            </div>
            <div class="Hum">
                <div class="Sign"><p class="Sign1">></p></div>
                <div class="Text"><p>Liste</p></div>
            </div>
        </div>
    </nav>
    <div class="SmallNavLinks">
        <ul>
            <li>
                <a href="/Pages/Articles.html">Articles</a>
            </li>
            <li>
                <a href="#">Clients</a>
            </li>
            <li>
                <a href="#">Stock</a>
            </li>
            <li>
                <a href="#">Commades</a>
            </li>
            <li>
                <a href="#">Login</a>
            </li>
        </ul>
    </div>
    <section class="ArtHome" id="ArtHome">
        <div class="LinksContainer">
            <ul>
                <li><a href="#ArtInsert">Inserer des articles</a></li>
                <li><a href="#ArtList">Liste Des articles</a></li>
                <li><a href="#">Importer EXCEL/XSV</a></li>
                <li><a href="#">Exporter (EXCEL)</a></li>
            </ul>
        </div>
    </section>
    <section class="ArtHome" id="ArtInsert" style="padding-top: 100px; padding-bottom: 20px;">
        <div class="LinksContainer">
            <caption><a>Insertion d'article</a></caption>
            <form autocomplete="off" action="" method="POST">
                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                <table>
                    <tr>
                        <td>
                            <p>Code Article : <span>*</span></p>
                            <input type="text" name="CodeArt" id="CodeArt" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Designation d'article : <span>*</span></p>
                            <input type="text" name="Designation" id="Designation" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Prix Unitaire d'article :</p>
                            <input type="text" name="Prix" id="Prix"></br>
                            <input type="button" value="Generer QR" onclick="Generate()" style="padding: 5px;">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Code Bar Generé :</p></br>
                            <div class="img">
                                
                            </div></br>
                            <p class="download">Telecharger Le Code</p><p class="Print">Imprimer Le Code</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input name="submit" type="submit" value="Inserer"></br>
                            <a href="#ArtHome">Menu</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </section>
    <section class="ArtHome" id="ArtList" style="padding-top: 100px; padding-bottom: 20px;">
        <div class="LinksContainer">
            <caption><a>Liste des articles</a></caption>
                <table>
                    <tr>
                        <th><p>Code Article</p></th>
                        <th><p>Designation</p></th>
                        <th><p>Prix Unitaire</p></th>
                    </tr>
                </table>
                <div class="Cont" style="height: fit-content; max-height: 400px; overflow-y: scroll;">
                    <table>
                        <?php 
                            $conn = mysqli_connect("localhost", "root", "", "gestiondevents");
                            if($conn -> connect_error)
                            {
                                die("Connection failed:". $conn-> connect_error);
                            }

                            $sql = "SELECT * from articles";
                            $result = $conn->query($sql);

                            if($result-> num_rows > 0)
                            {
                                while($row = $result-> fetch_assoc())
                                {
                                    echo "<tr><td><p>". $row["Code"] ."</p></td>"
                                    ."<td><p>". $row["Designation"] ."</p></td>"
                                    ."<td><p>". $row["Prix"] ."</p></td></tr>";
                                }
                            }
                        ?>
                    </table>
                </div>
                <table>
                    <tr>
                        <td>
                            <a href="#ArtHome">Modifier</a>
                        </td>
                        <td>
                            <a href="#ArtHome">Menu</a>
                        </td>
                        <td>
                            <a href="#ArtHome">Supprimer</a>
                        </td>
                    </tr>
                </table>
        </div>
    </section>
    <script>
        var hum = document.querySelector(".Hum");
        var qrcode = new QRCode(document.querySelector('.img'), {
            width:100,
            height:100
        })
        hum.addEventListener("click", ()=>
        {
            document.querySelector(".SmallNavLinks").classList.toggle("Active");
            if(document.querySelector("body").style.overflowY != "hidden"){
                document.querySelector("body").style.overflowY = "hidden";
            document.querySelector(".Sign1").innerText = "<";
            }else{
                document.querySelector("body").style.overflowY = "auto";
            document.querySelector(".Sign1").innerText = ">";
            }
        });
        var message = document.getElementById('CodeArt');
        function Generate()
        {
            if(!message.value){
                alert("Vous devez entrer le code article avant generer son QR");
                message.focus();
                return;
            }
            qrcode.makeCode(message.value);
        }
        document.querySelector('.download').addEventListener('click', ()=>
        {
            var imgOrURL = document.querySelector('.img > img').src;
            if(imgOrURL != "")
            {
                var canvas = document.querySelector(".img > canvas");
                var link = document.createElement('a');
                link.download = "QR.png";
                link.href = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");;
                link.click();
                link.remove();
            }else{
                alert("Vous devez generer le code avant de le telecharger");
            }
        });
        document.querySelector('.Print').addEventListener('click', ()=>
        {
            var imgOrURL = document.querySelector('.img > img').src;
            if(imgOrURL != "")
            {
                VoucherPrint(document.querySelector('.img > img').src);
            }else{
                alert("Vous devez generer le code avant de l'imprimer");
            }
        });
        function VoucherSourcetoPrint(source) 
        {
            return "<div style='width: 100%; height: 100%; display: flex; align-items:center; justify-content: center"+
                   "'><img style='height: 500px; width:500px;' src='" + source + "' /><script>window.print(); window.close()\n<" + "/script>";
        }
        function VoucherPrint(source) {
            Pagelink = "about:blank";
            var pwa = window.open(Pagelink, "_new");
            pwa.document.open();
            pwa.document.write(VoucherSourcetoPrint(source));
            pwa.document.close();
        }    
    </script>
</body>
</html>