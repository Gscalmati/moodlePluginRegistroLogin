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
require_once($CFG->dirroot. '/local/circuito/login_form.php');


$context = context_system::instance();


$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/circuito/login.php'));
$PAGE->set_pagelayout('standard');

// Con PAGE-> SET_TITLE defino el nombre de la pagina.
$PAGE->set_title("Inicio de Sesión e Inscripción");
$PAGE->set_heading(get_string('logintitle', 'local_circuito'));

// DB
global $DB;



// *** BODY DEL SITE ***//


echo $OUTPUT->header();
echo local_greetings_get_greeting($USER);
echo '<hr>';

$loginform = new local_circuito_login_form();
// Display del form -> $messageform.
$loginform->display();

// Display de Variables Query



// Consulto si se llenó la data.

if ($data = $loginform->get_data()) {

    // Como llamar un record desde la DB con la data ingresada en un campo
    // Se supone que la DATA viene llena y sanitizada
    $email = required_param('email', PARAM_TEXT);
    // Nombre de la tabla
    $table = "mdl_local_circuito_users";
    // Creación de la QUERY
    $sql = "SELECT * FROM {$table} WHERE email = " . $DB->sql_compare_text("'{$email}'");
    $dbdata = $DB->get_record_sql($sql, null, IGNORE_MISSING);

    echo html_writer::start_tag('div', array('class' => 'card'));
    echo html_writer::start_tag('div', array('class' => 'card-body'));
    echo html_writer::tag('p', $dbdata->id, array('class' => 'h3'));
    echo html_writer::start_tag('p', array('class' => 'card-text'));
    echo html_writer::tag('p', format_text($dbdata->name, FORMAT_PLAIN), array('class' => 'h2 bgc-dark'));
    echo html_writer::tag('p', format_text($dbdata->name, PARAM_PLAIN), array('class' => 'h2 bgc-dark'));
    // echo html_writer::tag('span', $dbdata->name, array('class' => 'h3'));
    echo html_writer::tag('span', " ");
    echo html_writer::tag('span', $dbdata->surname);
    echo html_writer::tag('p', $dbdata->email);
    echo html_writer::end_tag('p');
    echo html_writer::end_tag('div');
    echo html_writer::end_tag('div');

} else {
    echo '<p class="h3"> No encontrado </p>';
}


echo $OUTPUT->box_end();

echo $OUTPUT->footer();
