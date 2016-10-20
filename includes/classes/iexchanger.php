<?php
    interface IExchanger {
        public function getFiat();
        public function getCurrencies();
        public function convert($to, $from);
	public function getDisclaimer();
    }
