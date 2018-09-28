import { Component, OnInit, OnChanges, Input, EventEmitter } from '@angular/core';
import { MaterializeAction } from 'angular2-materialize';

@Component({
  selector: 'app-create-atividade-modal',
  templateUrl: './create-atividade-modal.component.html',
  styleUrls: ['./create-atividade-modal.component.css']
})
export class CreateAtividadeModalComponent implements OnInit, OnChanges {

	@Input('createClick') createClick: number;
	@Input('evento') evento: string;
	createAtividadeModal = new EventEmitter<string|MaterializeAction>();

  constructor() { }

  ngOnInit() {
  }

  ngOnChanges() {
		console.log(this.createClick);
		if(this.createClick)
			this.openModal();
	}

  openModal() {
  	this.createAtividadeModal.emit({action: 'modal', params: ['open']});
  }

}
