<?
/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */
?>
Der Server f&uuml;r dieses Spiel kostet Geld und wird haupts&auml;chlich durch Spenden finanziert - deshalb freuen wir uns &uuml;ber jede Spende. Sie helfen uns dabei, das Spiel weiter f&uuml;r euch betreiben zu k&ouml;nnen.
<br/>
Ab 5€ erhalten Spender einen bunten Nicknamen.
<br/>
<br/>
<center><b>Kontodaten</b></center>
Empfänger: Sebastian Mayer
<br/>
PSD Bank
<br/>
BLZ: 60090900
<br/>
Konto-Nummer: 7036425600
<br/>
F&uuml;r Spender aus dem Ausland:
<br/>
IBAN: DE09 6009 0900 7036 4256 00
<br/>
BIC: GENODEF1P20
<br/>
<br/>
Als Betreff am besten "Spende <?= Rakuun_User_Manager::getCurrentUser()->nameUncolored; ?>" angeben, damit wir die Spende problemlos zuordnen k&ouml;nnen.
<br/>
<br/>
<center><b>Paypal</b></center>
Spenden per Paypal sind möglich, kosten uns allerdings Geb&uuml;hren. Normale &Uuml;berweisungen sind uns daher lieber.
<div id="ctn_paypal_button">
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="FEUZ4QPNJQTLY">
	<input type="image" src="https://www.paypal.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
	<img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1">
	</form>
</div>
<br class="clear"/>