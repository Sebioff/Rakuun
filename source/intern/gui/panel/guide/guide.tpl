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
Das Ziel des Spiels ist das Bauen und Verteidigen des Mutterschiffs (Dancertia) gegen den Rest Rakuuns!
<br/>
<br/>
Um dies zu erreichen bedarf es ein paar Vorkehrungen:
<br/>
<br/>
<ol>
	<li>1. Die Allianz muss mindestens den Datenbankdetektor auf Stufe 3 ausbauen um 3 von insgesamt 5 Datenbankteilen zu sehen. Die Datenbankteile können erobert werden, indem der Spieler, der sie hält, angegriffen und zerstört wird. Ist seine Armee vollständig zerstört, so ist/sind die Datenbankteile freigelegt und können erobert werden. Ein Angriff mit min. 1000 Att reicht.</li>
	<li>2. Die Meta muss im Besitz von 3 der 5 Datenbankteile sein. Welche das sind spielt keine Rolle. Jedoch haben die Datenbankteile unterschiedliche Boni, die dem Halter und der Meta gewährt wird.</li>
	<li>3. Ist die 2. Voraussetzung erfüllt, so muss die Meta den Dancertia-Raumhafen bauen.</li>
	<li>4. Nachdem der Raumhafen fertiggestellt wurde, ist der Bau des Schildgenerators damit freigeschaltet. Die Schildgeneratoren dienen dazu das Mutterschiff (Dancertia) vor den Angreifen zu schützen. Jeder Spieler, der ein Schildgenerator besitzt, verteidigt automatisch die Dancertia mit seiner eigenen Fleet. Die Angreifer müssen <b>jedes</b> Schild zerstören, um den Sieg zu vereiteln. Es ist daher ratsam innerhalb der Meta so viele Schilde wie möglich zu bauen</li>
	<li>5. Nun müssen die Datenbankteile an jeden Spieler verteilt werden, der ein Schild bauen soll. Für das Schild sind 3 Datenbankteile notwendig, die bis zur Fertigstellung des Baus beim Spieler verbleiben müssen. Der Spieler sollte zudem online bleiben.</li>
	<li>6. Alle Allianzleiter können in der Metaübersicht sehen, welche Schilde bereits fertiggestellt wurden. Meint der Leiter genug Schilde zum Verteidigen der Dancertia zu haben, so baut er diese. Dies dauert einige Zeit.</li>
	<li>7. Ist die Dancertia fertiggestellt, so muss sie noch <?= Rakuun_Date::formatCountDown(RAKUUN_SPEED_DANCERTIA_STARTTIME); ?> den Angreifern stand halten. Existiert nach Ablauf des Countdowns noch mindestens ein Schild, so hat die Meta gewonnen. Andernfalls wurde die Dancertia abgeschossen und es muss ein neuer Versuch (von wem auch immer) unternommen werden. Auf der Startseite wird während des Countdowns ein Schild aufgedeckt sowie die Anzahl der Gesamtschilde preisgegeben. Es muss aber nicht das Schild auf der Startseite als erstes zerstört werden, stattdessen kann es auch jedes anderen beliebige Schild sein.</li>
</ol>
<br/>
Weitere Fragen können in der Shoutbox gestellt werden.