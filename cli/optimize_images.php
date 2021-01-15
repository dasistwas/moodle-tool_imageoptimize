<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Optimize images.
 *
 * @package    tool_imageoptimize
 * @copyright  2021 ISB Bayern
 * @author     Peter Mayer, peter.mayer@isb.bayern.de
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('CLI_SCRIPT', true);

require_once(dirname(__FILE__) . '/../../../../config.php');
require_once($CFG->libdir."/clilib.php");
require_once($CFG->dirroot ."/admin/tool/imageoptimize/classes/tool_image_optimize_helper.php");

core_php_time_limit::raise();

// Increase memory limit.
raise_memory_limit(MEMORY_EXTRA);

list($options, $unrecognized) = cli_get_params([
    'execute' => '',
    'help' => false,
    'chunksize' => 2000,
    'sort' => 'iddesc'
]);

if ($options['help']) {
    mtrace(
        "
        This script will bulk create a series of test courses with dummy data.

        --'execute'         will execute the script with all it's changes to DB [DANGER-MODE!].
        --'chunksize'       the maximum amound of images processed during one script call. If not set
                            the default value is 2000.
        --'sort'            Sortorder used to optimize files. Possible Values `idasc` and `iddesc`.
        "
    );
    die;
}

$imageoptimizehelper = \tool_imageoptimize\tool_image_optimize_helper::get_instance();
$imageoptimizehelper->cli_call_optimization($options);
