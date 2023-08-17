<?php

try
        {
            $bd = new PDO("mysql:host=localhost;dbname=projet2php;charset=utf8",'root','');
            $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            echo 'Erreur :'. $e->getMessage();
        }