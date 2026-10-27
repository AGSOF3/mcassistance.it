<?php

abstract class PersistentObject{
    
    abstract public function getKey();
    
    abstract public function setKey($key);
    
    abstract public function elementWithKey($key);
    
    public function __construct(){
        $this->setOnDB(false);
    }
    
    /**
     * Flag di avvenuta modifica.
     * Si consiglia di impostare questo flag a <code>true</code> nei metodi di set o prima di chiamare
     *  <code>save()</code>, perché la UPDATE non viene eseguita se <code>dirty</code> è <code>false</code>.
     * @see #save()
     */
    public $dirty;
    
    /**
     * Flag della presenza su database.
     * Viene usato da <code>save()</code> per decidere se eseguire una UPDATE o una INSERT. E' necessario
     * impostarlo esplicitamente a <code>false</code> se vengono cambiati gli attributi chiave.
     * @see #save()
     */
    public $onDB;
    
    /**
     * Imposta il flag onDB.
     * @param d il valore da impostare.
     **/
    public function setOnDB($onDB){
        $this->onDB = $onDB;
    }
    
    /**
     * Ritorna il valore del flag onDB.
     @return <code>true</code> o <code>false</code> a seconda che l'oggetto sia presente o meno nel database.
     **/
    public function isOnDB(){
        return $this->onDB;
    }
    
    /**
     * Imposta il flag dirty.
     * @param dirty il valore da impostare.
     **/
    public function setDirty($dirty){
            $this->dirty = $dirty;
    }
    
    /**
     * Restituisce il flag dirty.
     * return flag dirty.
     **/
    public function isDirty(){
        return $this->dirty;
    }
    
}

?>