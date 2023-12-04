<?php if (isset($_GET['code'])) {die(highlight_file(__File__, 1)); }?>
<?php
require ('conf.php');
require ('funktsioonid.php');
$sort = "eesnimi";
$otsisona = "";
if(isset($_REQUEST["sort"])) {
    $sort = $_REQUEST["sort"];
}
if(isset($_REQUEST["otsisona"])) {
    $otsisona = $_REQUEST["otsisona"];
}
if(isset($_REQUEST["inimene_lisamine"])){
    // ei luba tühja väli ja tühiku sisestamine
    if(!empty(trim($_REQUEST["eesnimi"])) && !empty(trim($_REQUEST["perenimi"])))
        lisaInimene($_REQUEST["eesnimi"], $_REQUEST["perenimi"], $_REQUEST["maakond_id"]);
    header("Location: index.php");
    exit();
}

if(isset($_REQUEST["maakonna_lisamine"])){
    lisaMaakond($_REQUEST["maakonnanimi"]);
    header("Location: index.php");
    exit();
}
if(isset($_REQUEST["salvesta"])){
    muudaInimene($_REQUEST["muuda_id"],$_REQUEST["eesnimi"], $_REQUEST["perekonnanimi"], $_REQUEST["maakond_id"] );
}


$inimesed=inimesteKuvamine($sort, $otsisona);
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Inimesed ja maakonnad</title>
</head>
<body>
<h1>Inimesed ja maakonnad</h1>

<form action="index.php">
    <input type="text" name="otsisona" placeholder="Otsi...">
</form>
<br>

<?php if(isset($_REQUEST["muutmine"])):?>
    <?php foreach($inimesed as $inimene): ?>
        <?php if($inimene->id==intval($_REQUEST["muutmine"])): ?>
            <form action="index.php">
                <input type="hidden" name="muuda_id" value="<?=$inimene->id?>">
                <input type="text" name="eesnimi" value="<?=$inimene->eesnimi?>">
                <input type="text" name="perekonnanimi" value="<?=$inimene->perekonnanimi?>">
                <?php
                echo selectLoend("Select id, maakond_nimi from maakond", "maakond_id");
                ?>

                <input type="submit" name="salvesta" value="Salvesta">
            </form>
        <?php endif ?>
    <?php endforeach; ?>
<?php endif ?>
<table border="1">
    <tr>
        <th>id</th>
        <th><a href="index.php?sort=eesnimi">Eesnimi</a></th>
        <th><a href="index.php?sort=perekonnanimi">Perenimi</a></th>
        <th><a href="index.php?sort=maakond_nimi">Maakond</a></th>
    </tr>
    <?php foreach($inimesed as $inimene): ?>
        <tr>
            <td><?=$inimene->id ?></td>
            <td><?=$inimene->eesnimi ?></td>
            <td><?=$inimene->perekonnanimi ?></td>
            <td><?=$inimene->maakond_nimi ?></td>
            <td><a href="index.php?muutmine=<?=$inimene->id?>"> Muuda</a></td>
        </tr>
    <?php endforeach; ?>

</table>
<br>

<form action="index.php">
    <input type="text" name="eesnimi" placeholder="eesnimi">
    <input type="text" name="perenimi" placeholder="perenimi">
    <?php
    echo selectLoend("Select id, maakond_nimi from maakond", "maakond_id");
    ?>

    <input type="submit" value="Lisa inimene" name="inimene_lisamine">
</form>
<br>
<form action="index.php">
    <input type="text" name="maakonnanimi" placeholder="maakond">
    <input type="submit" name="maakonna_lisamine" value="lisa maakond">

</form>

</body>
</html>