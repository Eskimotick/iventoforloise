import { Component, OnInit, EventEmitter } from '@angular/core';
import { MaterializeAction } from 'angular2-materialize';

@Component({
  selector: 'app-create-atividade-modal',
  templateUrl: './create-atividade-modal.component.html',
  styleUrls: ['./create-atividade-modal.component.css']
})
export class CreateAtividadeModalComponent implements OnInit {

	createAtividadeModal = new EventEmitter<string|MaterializeAction>();

  constructor() { }

  ngOnInit() {
  }

  openModal() {
  	this.createAtividadeModal.emit({action: 'modal', params: ['open']});
  }

}
