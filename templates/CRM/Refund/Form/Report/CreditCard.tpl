{*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.7                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2016                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
*}
{include file="CRM/Report/Form.tpl"}
<span class='closing_time_help'>{help id="closing_time"}</span>
{literal}
<script type="text/javascript">

CRM.$(function($) {
  $('tr.crm-report-criteria-filter #s2id_closing_time_relative').hide();
  $('tr.crm-report-criteria-filter span.crm-absolute-date-to #closing_time_to').parent().hide();
  $('tr.crm-report-criteria-filter span.crm-absolute-date-from label[for="closing_time_from"]').hide();
  $('tr.crm-report-criteria-filter span.crm-absolute-date-from label[for="closing_time_from_time"]').text('Closing Time');
  $('tr.crm-report-criteria-filter span.crm-absolute-date-from #closing_time_from').next().hide();
  $('tr.crm-report-criteria-filter span.crm-absolute-date-from #closing_time_from').parent().append($('span.closing_time_help'));
});

</script>
{/literal}