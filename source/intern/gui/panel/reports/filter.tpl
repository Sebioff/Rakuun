<? $this->displayPanel('filter'); ?>
<? $this->displayPanel('how'); ?>
<? $this->displayPanel('what'); ?>
<br class="clear" />
<? for ($i = 0; $i < Rakuun_Intern_GUI_Panel_Reports_Filter::FILTER_COUNT; $i++): ?>
	<? $this->displayPanel('filter'.$i); ?>
	<? $this->displayPanel('how'.$i); ?>
	<? $this->displayPanel('what'.$i); ?>
	<br class="clear" />
<? endfor; ?>
<? $this->displayPanel('submit'); ?>