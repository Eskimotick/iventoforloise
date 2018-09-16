import { Component, OnInit, OnChanges, Input, EventEmitter } from '@angular/core';
import { MaterializeAction } from 'angular2-materialize';


@Component({
  selector: 'app-update-atividade-modal',
  templateUrl: './update-atividade-modal.component.html',
  styleUrls: ['./update-atividade-modal.component.css']
})
export class UpdateAtividadeModalComponent implements OnInit, OnChanges {

	@Input('evento') evento: string;
	@Input('updateAtividade') updateAtividade: any;
	@Input('atividadeClick') atividadeClick: number;
	updateAtividadeModal = new EventEmitter<string|MaterializeAction>();

  constructor() { }

  ngOnInit() {
  }

  ngOnChanges() {
		console.log(this.atividadeClick, this.updateAtividade);
		this.updateAtividadeModal.emit({action: 'modal', params: ['open']});
	}

	//verifica se o evento ocorre no mesmo dia
	oneDay() {
  	return this.updateAtividade.start.substring(8, 10) == this.updateAtividade.end.substring(8, 10);
  }

}
