<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de busqueda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/d70d441cb5.js" crossorigin="anonymous"></script>
    <style>
        body{
            margin: 25px;
        }
        #search-addon{

            background-image: url("magnifying-glass-solid.svg") !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: 75% !important;
        }
    </style>
</head>
<body>
    

<form action="index.php" method="get" lass="input-group rounded" style="width: 20%; float:right">
  <input type="text" class="form-control rounded" placeholder="Buscar precio..." aria-label="Search" aria-describedby="search-addon"
   name="buscar"/>
   <input type="checkbox" id="" name="cookies" value="1"> Borrar Cookies Anteriores
  <input type="submit" class="input-group-text border-0" id="search-addon" value=""/>
</form>


    <?php
        if (isset($_GET["cookies"])) {
            if ($_GET["cookies"] == 1){
                setcookie('precio','',time()-100);
                echo "Cookies anteriores borradas";
            }
        }
        try {
            if (isset($_GET["buscar"]) && is_numeric($_GET["buscar"])) {
            // conexion
            $precio_buscado = intval($_GET["buscar"]);
            $conexion = mysqli_connect("localhost", "root", "", "northwind");
            setcookie("precio", $precio_buscado);
            
            $cons = "SELECT ProductName, QuantityPerUnit, round(UnitPrice,2), UnitsInStock, UnitsOnOrder FROM products where UnitPrice > $precio_buscado ORDER BY UnitPrice ASC";
            $resultado = mysqli_query($conexion, $cons);
        
        ?>
        
        
<table class="table" style="width: 100%;">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Unidades</th>
        </tr>
    </thead>
    <?php
        $a = 0;
        while ($fila = mysqli_fetch_row($resultado)) {
            echo "<tr>";
            for ($i=0; $i < 3; $i++) { 
                echo "<td>";
                echo ($fila[$i]);
                echo "</td>";
                
            }
                echo "<td>";
                echo ($fila[3]);
                if ($fila[4] != 0) {
                    echo" (Próximamente: $fila[4])";
                }
                echo "</td>";
            echo "</tr>";
            $a++;
        }
        echo "<p>Hay ".$a." resultado(s)</p>";
    }else{
        echo "<p> Introduce un precio para buscar</p>";
    }
        } catch (Exception $e) {
            echo "<p> Introduce un precio correcto.</p>";
        }
    ?>
</table>

</body>
</html>
