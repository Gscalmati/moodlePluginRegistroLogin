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
require_once('../../config.php');
require_once($CFG->dirroot. '/local/circuito/lib.php');
require_once($CFG->dirroot. '/local/circuito/register_form.php');

$context = context_system::instance();

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/circuito/index.php'));
$PAGE->set_pagelayout('standard');

// Con PAGE-> SET_TITLE defino el nombre de la pagina.
$PAGE->set_title("Formulario de Registro");
$PAGE->set_heading(get_string('pluginname', 'local_circuito'));

// Validaciones de autenticacion
require_login();

if (isguestuser()) {
    throw new moodle_exception('noguest');
}

// *** BODY DEL SITE ***//
$registerform = new local_circuito_register_form();

echo $OUTPUT->header();
echo local_greetings_get_greeting($USER);
echo '<hr>';

// Display del form -> $messageform.
$registerform->display();

echo '<hr>';

// Botón para Enviar al Login
echo '<a class="btn btn-dark" href="/moodle/local/circuito/login.php">Login</a>';


// Consulto si se llenó la data.

if ($registerform->get_data()) {
    // Se supone que la DATA viene llena y sanitizada

     $name = required_param('name', PARAM_TEXT);
     $surname = required_param('surname', PARAM_TEXT);
     $email = required_param('email', PARAM_NOTAGS);

    // echo $OUTPUT->heading($message, 4); - Esto seria para escribirlo en pleno Body

        $record = new stdClass;
        $record->name = $name;
        $record->surname = $surname;
        $record->email = $email;
        $record->userid = $USER->id;
        $record->timecreated = time();

        $DB->insert_record('local_circuito_users', $record);

        $urltogo = $CFG->wwwroot.'/local/circuito/login.php';
        redirect($urltogo);
}

echo $OUTPUT->box_end();

echo $OUTPUT->footer();
