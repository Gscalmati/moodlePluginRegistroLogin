<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin version and other meta-data are defined here.
 *
 * @package   local_circuito
 * @copyright 2022 Giovanni <giovanni.scalmati@hospitalitaliano.org.ar>
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once '../../config.php';
require_once $CFG->dirroot. '/local/circuito/lib.php';
require_once $CFG->dirroot. '/local/circuito/login_form.php';

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/circuito/login.php'));
$PAGE->set_pagelayout('standard');

// Con PAGE-> SET_TITLE defino el nombre de la pagina.
$PAGE->set_title("Inicio de Sesión e Inscripción");
$PAGE->set_heading(get_string('logintitle', 'local_circuito'));

//*** BODY DEL SITE ***//
$loginform = new local_circuito_login_form();

echo $OUTPUT->header();
echo local_greetings_get_greeting($USER);
echo '<hr>';

// Display del form -> $messageform.
$loginform->display();

echo $OUTPUT->box_end();
// Consulto si se llenó la data.

if ($data = $loginform->get_data()) {
    //Se supone que la DATA viene llena y sanitizada
    $name = required_param('name', PARAM_TEXT);

    $dbdata = $DB->get_data();
    echo $dbdata;
}



echo $OUTPUT->footer();
