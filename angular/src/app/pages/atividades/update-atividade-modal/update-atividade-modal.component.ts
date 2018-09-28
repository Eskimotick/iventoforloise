import { Component, OnInit, OnChanges, Input, Output, EventEmitter } from '@angular/core';
import { MaterializeAction } from 'angular2-materialize';
import * as moment from 'moment';

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
  @Output() updateTitleEmitter = new EventEmitter<any|any>();

  atividadeOnEdit: any;
  descriptionOnEdit: boolean;
	footer: string;
  editAction: string;

  constructor() {
  	this.footer = '';
    this.atividadeOnEdit = '';
    this.descriptionOnEdit = false;
    this.editAction = '';
  }

  ngOnInit() {
  }

  ngOnChanges() {
		console.log(this.atividadeClick, this.updateAtividade);
    if(this.atividadeOnEdit)
      this.atividadeOnEdit = '';
    if(this.descriptionOnEdit)
      this.descriptionOnEdit = false;
    if(this.footer)
		  this.footer = '';
    if(this.editAction)
      this.editAction = '';
    if(this.updateAtividade)
		  this.updateAtividadeModal.emit({action: 'modal', params: ['open']});
	}

	// verifica se o evento ocorre no mesmo dia
	oneDay() {
    let start = moment(this.updateAtividade.start);
    let end = moment(this.updateAtividade.end);
  	return !end.diff(start, 'days');
  }

  // muda o tipo de ação do footer
  actionFooter(action: string) {
  	this.footer = action;
  }

  // campo do modal que está em edição
  editMode(section: string) {
    this.editAction = section;
    if(section == 'palestrante') 
      this.atividadeOnEdit = this.updateAtividade.palestrante;
    else if(section == 'vagas')
      this.atividadeOnEdit = this.updateAtividade.qntdVagas;
    else if(section == 'descricao' && !this.descriptionOnEdit) {
      this.atividadeOnEdit = this.updateAtividade.descricao;
      this.descriptionOnEdit = true;
    }
    else if(section == 'pacotes')
      this.atividadeOnEdit = this.updateAtividade.pacotes;
    else if(section == 'data')
      this.atividadeOnEdit = { start: this.updateAtividade.start, end: this.updateAtividade.end };
    else if(!section) {
      this.atividadeOnEdit = '';
      this.descriptionOnEdit = false;
    }
  }

  // editando as checkboxes
  pacotesOnChange(index: any) {
    let id = this.atividadeOnEdit.indexOf(index);
    if(id == -1)
      this.atividadeOnEdit.push(index);
    else
      this.atividadeOnEdit.splice(id, 1);
  }

  // salva o que foi alterado
  saveEdit() {
    if(this.editAction == 'titulo')
      this.updateTitleEmitter.emit({id: this.updateAtividade.id, title: this.updateAtividade.title});
    else if(this.editAction == 'palestrante')
      this.updateAtividade.palestrante = this.atividadeOnEdit;
    else if(this.editAction == 'vagas')
      this.updateAtividade.qntdVagas = this.atividadeOnEdit;
    else if(this.editAction == 'descricao') {
      this.updateAtividade.descricao = this.atividadeOnEdit;
      this.descriptionOnEdit = false;
    }
    else if(this.editAction == 'pacotes')
      this.updateAtividade.pacotes = this.atividadeOnEdit;
    this.editAction = '';
  }

  // cancela/não salva se apertar o 'x' ou fechar o modal
  cancelEdit() {
    this.editAction = '';
    this.atividadeOnEdit = '';
    if(this.descriptionOnEdit)
      this.descriptionOnEdit = false;
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
