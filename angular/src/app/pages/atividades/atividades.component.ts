import { Component, OnInit, ViewChild, EventEmitter } from '@angular/core';
import { CalendarComponent } from 'ng-fullcalendar';
import { Options } from 'fullcalendar';
import { MaterializeAction } from 'angular2-materialize';

@Component({
  selector: 'app-atividades',
  templateUrl: './atividades.component.html',
  styleUrls: ['./atividades.component.css']
})
export class AtividadesComponent implements OnInit {

	//variaveis para funcionamento do fullcalendar
  @ViewChild(CalendarComponent) ucCalendar: CalendarComponent;
  calendarOptions: Options;

  //carregando os eventos do calendário
  evento: any = {
  	id: 0, title: 'Evento 1', start: '2018-09-04', end: '2018-09-11', rendering: 'background'
  };
  atividade: any[] = [
		{ id: 1, title: 'Cagar no Pau', start: '2018-09-05T12:00:00', end: '2018-09-05T18:00:00', 
		descricao: 'Atividade que faço com qualquer projeto', palestrante: 'Shakira', qntdVagas: 31, status: true, disp: 0,
		pacotes: ['EJCM', 'Diretoria de Projetos'], image: 'https://www.planwallpaper.com/static/images/general-night-golden-gate-bridge-hd-wallpapers-golden-gate-bridge-wallpaper.jpg' },

		{ id: 2, title: 'Codar Ivento', start: '2018-09-05T11:30:00', end: '2018-09-08T13:50:00', 
		backgroundColor: 'red', borderColor: 'red', palestrante: 'Teteu', qntdVagas: 1, status: false, 
		pacotes: ['EJCM', 'Diretoria de Projetos','Equipe Ivento'] }  	
  ]; 

  //para pegar a atividade que foi clicada
  updateAtividade: any;
  atividadeClick: number;

  constructor() { 
  	this.atividadeClick = 0;
  }

  ngOnInit() {
  	//personalizando as opções do fullcalendar
		this.calendarOptions = {
			locale: 'pt-br',
			editable: true,
			eventLimit: false,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			buttonText: {
				today: 'Hoje',
				month: 'Mês',
				week: 'Semana',
				day: 'Dia'
			},
			events: []
		};
		this.initEvents();
  }

  //inicializa o evento e as atividades do calendário
  initEvents() {
  	this.calendarOptions.events.push(this.evento);
  	for(let i = 0; i < this.atividade.length; i++)
  		this.calendarOptions.events.push(this.atividade[i]);
  }

  //pega a atividade que foi clicada
  eventClick(atividade) {
  	this.atividadeClick++;
  	let i = this.atividade.findIndex(at => at.id == atividade.event.id);
  	this.updateAtividade = this.atividade[i];
  }

}
