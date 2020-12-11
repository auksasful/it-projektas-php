<?php

/**
 * Just a little page footer, tells how many registered members
 * there are, how many users currently logged in and viewing site,
 * and how many guests viewing site. 
 */
if (isset($database)) {
    echo "<div class='panel panel-warning'>
      <div class='panel-heading'><b>Registruotų vartotojų kiekis: </b> " . $database->getNumMembers() . ".&nbsp"
    . "<b>Dabar prisijungę: </b> " . $database->num_active_users . ".&nbsp"
    . "<b>Svečiai: </b> " . $database->num_active_guests . ".&nbsp</div></div>"
    . ""
    ;
}
