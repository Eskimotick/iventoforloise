import { Component, OnInit, OnChanges, Input, Output, EventEmitter } from '@angular/core';
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
	@Output() deleteAtividadeEmitter = new EventEmitter<number>();

	footer: string;

  constructor() {
  	this.footer = '';
  }

  ngOnInit() {
  }

  ngOnChanges() {
		console.log(this.atividadeClick, this.updateAtividade);
		this.footer = '';
		this.updateAtividadeModal.emit({action: 'modal', params: ['open']});
	}

	//verifica se o evento ocorre no mesmo dia
	oneDay() {
  	return this.updateAtividade.start.substring(8, 10) == this.updateAtividade.end.substring(8, 10);
  }

  actionFooter(action: string) {
  	this.footer = action;
  }

  //inscreve o usuario na atividade
  inscricao(cpf: any) {
  	console.log(cpf);
  	this.footer = '';
  }

  //apaga atividade e fecha o modal
	deleteAtividade() {
		this.deleteAtividadeEmitter.emit(this.updateAtividade.id);
		this.updateAtividadeModal.emit({action: 'modal', params: ['close']});
	}

}
