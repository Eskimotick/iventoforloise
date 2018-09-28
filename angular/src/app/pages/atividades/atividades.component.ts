import { Component, OnInit, ViewChild, EventEmitter } from '@angular/core';
import { CalendarComponent } from 'ng-fullcalendar';
import { Options } from 'fullcalendar';
import { MaterializeAction } from 'angular2-materialize';
import * as moment from 'moment';

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

  pacotes: string[] = [
    'EJCM', 'Diretoria de Projetos', 'Diretoria de Marketing', 'Equipe Ivento', 'Equipe Bikeme', 'Equipe Sintaf'
  ];

  atividade: any[] = [
		{ id: 1, title: 'Cagar no Pau', start: '2018-09-05T12:00:00', end: '2018-09-05T18:00:00', 
		descricao: 'Atividade que faço com qualquer projeto', palestrante: 'Shakira', qntdVagas: 31, status: true, disp: 0,
		pacotes: [0, 1], image: 'https://www.planwallpaper.com/static/images/general-night-golden-gate-bridge-hd-wallpapers-golden-gate-bridge-wallpaper.jpg' },

		{ id: 2, title: 'Codar Ivento', start: '2018-09-05T11:30:00', end: '2018-09-08T13:50:00', 
		backgroundColor: 'red', borderColor: 'red', palestrante: 'Teteu', qntdVagas: 1, status: false, 
		pacotes: [0, 1, 4] }  	
  ]; 

  //para pegar a atividade que foi clicada
  updateAtividade: any;
  atividadeClick: number;

  errorUpdateToast = new EventEmitter<string|MaterializeAction>();

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

  updateEvent(atividade) {
    let i = this.atividade.findIndex(at => at.id == atividade.event.id);

    let start = moment(this.evento.start);
    let end = moment(this.evento.end);

    let newDateStart = moment(this.atividade[i].start).add(atividade.duration);
    let newDateEnd = moment(this.atividade[i].end).add(atividade.duration);

    if((newDateStart.diff(start, 'hours') >= 0) && (end.diff(newDateEnd, 'hours') >= 0)) {
    	this.atividade[i].start = newDateStart.format('YYYY-MM-DDTHH:mm:ss');
    	this.atividade[i].end = newDateEnd.format('YYYY-MM-DDTHH:mm:ss');
    } else {
    	atividade.event.start = moment(this.atividade[i].start);
    	atividade.event.end = moment(this.atividade[i].end);
    	this.ucCalendar.fullCalendar('updateEvent', atividade.event);
    	this.errorUpdateToast.emit('toast');
    }

    console.log(atividade);

  }

  deleteAtividade(eventId) {
    this.ucCalendar.fullCalendar('removeEvents', eventId);
  }

  updateTitle(event) {
    let atividade = this.ucCalendar.fullCalendar('clientEvents', event.id);
    atividade[0].title = event.title;
    this.ucCalendar.fullCalendar('updateEvent', atividade[0]);
  }
}
