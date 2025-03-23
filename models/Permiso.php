<?php

namespace app\models;

use Yii;

class Permiso
{
    public static function seccion($seccion = null)
    {
        if (
            /** Verifica si es usuario */
            !Yii::$app->user->isGuest &&
            /** Verifica si el usuario está habilitado */
            Yii::$app->user->identity->estatus &&
            /** Verifica si el rol está habilitado */
            Yii::$app->user->identity->rol->estatus
        ) {
            if ($seccion) {
                return self::buscar($seccion);
            } else {
                if ($url = self::url())
                    return self::buscar($url[0]);
            }
        }
        return false;
    }

    public static function accion($seccion = null, $accion = null)
    {
        if (
            /** Verifica si es usuario */
            !Yii::$app->user->isGuest &&
            /** Verifica si el usuario está habilitado */
            Yii::$app->user->identity->estatus &&
            /** Verifica si el rol está habilitado */
            Yii::$app->user->identity->rol->estatus
        ) {
            if ($seccion == null && $accion == null) {
                if ($url = self::url()) {
                    return self::buscar($url[0], $url[1]);
                }
            } else
                if ($seccion != null && $accion != null)
                return self::buscar($seccion, $accion);
        }
        return false;
    }

    public static function url()
    {
        $controladorAccion = [];
        if (isset($_REQUEST['r']))
            $controladorAccion = explode('/', $_REQUEST['r']);
        return $controladorAccion;
    }

    public static function buscar($seccion, $accion = null)
    {
        /** Obtiene los privilegios del usuario */
        $privilegios = Yii::$app->user->identity->rol->privilegios;
        foreach ($privilegios as $privilegio) {
            if (
                /** Verifica si el privilegio está habilitado */
                $privilegio->estatus &&
                /** Verifica si tiene asignada la sección */
                $privilegio->seccion->identificador == $seccion &&
                /** Verifica si la sección está habilitada */
                $privilegio->seccion->estatus
            ) {
                /** Verifica si el atributo accion está inicializado */
                if($accion == null){
                    return true;
                } else {
                    if (
                        $privilegio->accion &&
                        /** Verifica si tiene asignada la acción */
                        $privilegio->accion->identificador == $accion &&
                        /** Verifica si la acción está habilitada */
                        $privilegio->accion->estatus
                    ) {
                        return true;
                    } 
                }
            }
        }
        /** Si no encuentra coincidencia en sección y acción */
        return false;
    }
}
