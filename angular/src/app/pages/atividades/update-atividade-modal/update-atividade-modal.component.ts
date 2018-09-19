import { Component, OnInit, OnChanges, Input, Output, EventEmitter } from '@angular/core';
import { MaterializeAction } from 'angular2-materialize';


@Component({
  selector: 'app-update-atividade-modal',
  templateUrl: './update-atividade-modal.component.html',
  styleUrls: ['./update-atividade-modal.component.css']
})
export class UpdateAtividadeModalComponent implements OnInit, OnChanges {

	@Input('evento') evento: string;
  @Input('pacotes') pacotes: string[];
  @Input('updateAtividade') updateAtividade: any;
	@Input('atividadeClick') atividadeClick: number;
	updateAtividadeModal = new EventEmitter<string|MaterializeAction>();
	@Output() deleteAtividadeEmitter = new EventEmitter<number>();

	footer: string;
  editAction: string;

  constructor() {
  	this.footer = '';
    this.editAction = '';
  }

  ngOnInit() {
  }

  ngOnChanges() {
		console.log(this.atividadeClick, this.updateAtividade);
		this.footer = '';
    this.editAction = '';
		this.updateAtividadeModal.emit({action: 'modal', params: ['open']});
	}

	// verifica se o evento ocorre no mesmo dia
	oneDay() {
  	return this.updateAtividade.start.substring(8, 10) == this.updateAtividade.end.substring(8, 10);
  }

  // muda o tipo de ação do footer
  actionFooter(action: string) {
  	this.footer = action;
  }

  // campo do modal que está em edição
  editMode(section: string) {
    console.log(section);
    this.editAction = section;
  }

  // inscreve o usuario na atividade
  inscricao(cpf: any) {
  	console.log(cpf);
  	this.footer = '';
  }

  // apaga atividade e fecha o modal
	deleteAtividade() {
		this.deleteAtividadeEmitter.emit(this.updateAtividade.id);
		this.updateAtividadeModal.emit({action: 'modal', params: ['close']});
	}

  // pacotes permitido na atividade
  pacotePermitido(pacoteIndex: number) {
    for(let i = 0; i < this.updateAtividade.pacotes.length; i++) {
      if(pacoteIndex == this.updateAtividade.pacotes[i])
        return true;
    }
    return false;
  } 

}
