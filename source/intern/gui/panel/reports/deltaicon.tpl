<span class="rakuun_delta_<? if ($this->delta > 0): ?>up<? elseif ($this->delta < 0): ?>down<? else: ?>equal<? endif; ?>"><? if ($this->delta > 0): ?>+<? endif; ?><?= Text::formatNumber($this->delta); ?></span>