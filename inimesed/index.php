<?php if (isset($_GET['code'])) {die(highlight_file(__File__, 1)); }?>
<?php
require ('conf.php');
require ('funktsioonid.php');
$sort = "eesnimi";
$otsisona = "";
global $yhendus;
if(isset($_REQUEST["sort"])){
    $sort = $_REQUEST["sort"];
}
if(isset($_REQUEST["otsisona"])){
    $otsisona = $_REQUEST["otsisona"];
}

if(isset($_REQUEST["inimene_lisamine"])){
    //ei luba tühja väli ja tühiku sisestamine
    if(!empty(trim($_REQUEST["eesnimi"])) && !empty(trim($_REQUEST["perenimi"]))){
        lisaInimene($_REQUEST["eesnimi"],$_REQUEST["perenimi"],$_REQUEST["maakond_id"]);
    }
    header("Location: index.php");
    exit();
}

if(isset($_REQUEST["maakond_lisamine"])){
    //ei luba tühja väli ja tühiku sisestamine
    if(!empty(trim($_REQUEST["maakond"]))){
        lisaMaakond($_REQUEST["maakond"]);
    }
    header("Location: index.php");
    exit();
}

//andmete kustutamine tabelist
if(isset($_REQUEST["kustuta"])){
    $paring = $yhendus->prepare("DELETE FROM inimene WHERE id=?");
    $paring->bind_param("i", $_REQUEST["kustuta"]);
    $paring->execute();
    header("Location: index.php");
}

if(isset($_REQUEST["muutmine"])){
    muudaInimene($_REQUEST["muuda_id"],$_REQUEST["eesnimi"],$_REQUEST["perekonnanimi"]);
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
<table border="1">
    <tr>
        <form action="index.php">
            <td><input type="text" name="eesnimi" placeholder="eesnimi"></td>
            <td><input type="text" name="perenimi" placeholder="perenimi"></td>
            <td><?php echo selectLoend("select id, maakond_nimi from maakond","maakond_id"); ?></td>
            <td colspan="2"><input type="submit" value="Lisa inimene" name="inimene_lisamine" style="width: 100%;"></td>
        </form>
    </tr>
    <tr>
        <form action="index.php">
            <td colspan="4"><input type="text" name="maakond" placeholder="maakond" style="width: 100%;"></td>
            <td><input type="submit" value="Lisa maakond" name="maakond_lisamine" style="width: 100%;"></td>
        </form>
    </tr>
    <tr>
        <form action="index.php">
            <td colspan="4"><input type="text" name="otsisona" placeholder="otsi inimest nimega" style="width: 100%;"></td>
            <td><input type="submit" value="Otsi" style="width: 100%;"></td>
        </form>
    </tr>
    <tr>
        <th>Id</th>
        <th><a href="index.php?sort=eesnimi">Eesnimi</a></th>
        <th><a href="index.php?sort=perekonnanimi">Perenimi</a></th>
        <th><a href="index.php?sort=maakond_nimi">Maakond</a></th>
        <th>Kustuta</th>
    </tr>

        <?php foreach ($inimesed as $inimene): ?>
            <?php if($inimene->id==($_REQUEST["muutmine"])): ?>
    <form action="index.php">
        <input type="hidden" name="muuda_id" value="<?=$inimene->id?>">
        <input type="text" name="eenimi" value="<?=$inimene->perekonnanimi?>">
        <input type="text" name="perekonnanimi" value="<?=$inimene->perekonnanimi?>">
        <input type="submit" name="salvesta" value="salvesta">
    </form>
        <?php endif ?>
    <tr>
        <td><?=$inimene->id ?></td>
        <td><?=$inimene->eesnimi ?></td>
        <td><?=$inimene->perekonnanimi ?></td>
        <td><?=$inimene->maakond_nimi ?></td>
        <td><?="<a href='?kustuta=$inimene->id'>Kustuta</a>"?></td>
        <td><a href='index.php'<>>Muuda</a></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>