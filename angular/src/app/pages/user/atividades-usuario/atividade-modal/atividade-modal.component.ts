import { Component, OnInit, OnChanges, Input, EventEmitter } from '@angular/core';
import { MaterializeAction } from 'angular2-materialize';
import * as moment from 'moment';

import { UserService } from '../../../../services/user/user.service';

@Component({
  selector: 'app-atividade-modal',
  templateUrl: './atividade-modal.component.html',
  styleUrls: ['./atividade-modal.component.css']
})
export class AtividadeModalComponent implements OnInit, OnChanges {

	@Input('evento') evento: string;
  @Input('atividade') atividade: any;
	@Input('atividadeClick') atividadeClick: number;
	atividadeModal = new EventEmitter<string|MaterializeAction>();

	footer: string;

  constructor(private userService: UserService) { 
  	this.footer = '';
  }

  ngOnInit() {
  }

  ngOnChanges() {
    if(this.footer)
		  this.footer = '';
    if(this.atividade)
		  this.atividadeModal.emit({action: 'modal', params: ['open']});
  }

  // verifica se o evento ocorre no mesmo dia
	oneDay() {
    let start = moment(this.atividade.start);
    let end = moment(this.atividade.end);
  	return !end.diff(start, 'days');
  }

  inscrever() {
  	this.userService.inscreveAtividadePacote(this.atividade.id).subscribe(
  		(res) => {
  		console.log(res);
  	});
  }

  desinscrever() {
  	this.userService.desinscreveAtividade(this.atividade.id).subscribe(
  		(res) => {
  			console.log(res);
  	});
  }

}
