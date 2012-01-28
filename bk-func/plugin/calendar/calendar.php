<?php
	class event {
		/** variable to save the title of the event */
		private $title;
		
		/** variable to save the description of the event */
		private $description;
		
		/** variable to save the starttime of the event */
		private $start;
		
		/** variable to save the enttime of the event */
		private $end;
		
		
		/** returns the description of the event */
		public function getDescription() {
			return $this->description;
		}
		
		/** returns the starttime of the event */
		public function getStart() {
			return $this->start;
		}
		
		/** returns the endtime of the event */
		public function getEnd() {
			return $this->end;
		}
		
		/** returns the title of the event */
		public function getTitle() {
			return $this->title;
		}
		
		/**
		 * returns the duration of the event<br />
		 * duration is defined as:<br />
		 * <code>endtime - starttime</code>
		 */
		public function getDuration() {
			return $this->end - $this->start;
		}
	}
?>