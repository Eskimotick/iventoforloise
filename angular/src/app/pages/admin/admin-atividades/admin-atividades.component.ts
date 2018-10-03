import { Component, OnInit, ViewChild, EventEmitter } from '@angular/core';
import { CalendarComponent } from 'ng-fullcalendar';
import { Options } from 'fullcalendar';
import { MaterializeAction } from 'angular2-materialize';
import * as moment from 'moment'; 

import { PacotesService } from '../../../services/pacotes/pacotes.service';
import { AtividadesService } from '../../../services/atividades/atividades.service';

@Component({
  selector: 'app-admin-atividades',
  templateUrl: './admin-atividades.component.html',
  styleUrls: ['./admin-atividades.component.css']
})
export class AdminAtividadesComponent implements OnInit {

  // variaveis para funcionamento do fullcalendar
  @ViewChild(CalendarComponent) ucCalendar: CalendarComponent;
  calendarOptions: Options;

  // carregando os eventos do calendário
  evento: any = {
  	id: 0, title: 'Evento 1', start: '2018-09-04', end: '2018-09-11', rendering: 'background'
  };

  // pacotes do evento
  pacotes: any[] = [];

  // para pegar a atividade que foi clicada
  atividade: any;
  atividadeClick: number;

  // toast para caso o usuário tentou atualizar a data da atividade para fora do evento
  errorUpdateToast = new EventEmitter<string|MaterializeAction>();

  // pra detectar se o usuário clicou no caléndário numa data para criar uma atividade
  createClick: number;
  createDate: string;


  constructor(private pacotesService: PacotesService, private atividadesService: AtividadesService) { 
  	this.atividadeClick = 0;
    this.createClick = 0;
    this.createDate = '';
  }

  ngOnInit() {
  	// personalizando as opções do fullcalendar
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
    this.pacotesService.index().subscribe(
      (res) => {
        for(let i = 0; i < res.data.length; i++)
          this.pacotes.push(res.data[i]);
    });
    this.atividadesService.index().subscribe(
      (res) => {
        console.log(res);
        this.initEvents(res.data);
    });
  }

  // inicializa o evento e as atividades do calendário
  initEvents(atividadesJson) {
    if(this.ucCalendar) {
      let atividade: any = {};
      // atividade.pacotes = [];
    	this.ucCalendar.fullCalendar('renderEvent', this.evento, true);
      for(let i = 0; i < atividadesJson.length; i++) {
        atividade.pacotes = [];
        atividade.id = atividadesJson[i].ID;
        atividade.title = atividadesJson[i].titulo;
        atividade.start = moment(atividadesJson[i].data_inicio).format('YYYY-MM-DDTHH:mm');
        atividade.end = moment(atividadesJson[i].data_fim).format('YYYY-MM-DDTHH:mm');
        atividade.palestrante = atividadesJson[i].palestrante;
        atividade.descricao = atividadesJson[i].descricao;
        atividade.status = atividadesJson[i].status;
        atividade.qntdVagas = atividadesJson[i].vagas;
        atividade.image = atividadesJson[i].img;
        for(let j = 0; j < atividadesJson[i].pacotes.length; j++)
          atividade.pacotes.push(atividadesJson[i].pacotes[j].id);
        this.ucCalendar.fullCalendar('renderEvent', atividade, true);
      }
    } else {
      setTimeout(() => {
        this.initEvents(atividadesJson);
      }, 500);
    }
  }

  // se o usuario clicar num dia vazio ele abre uma modal de criar atividade
  dayClick(atividade) {
    this.createClick++;
    this.createDate = moment(atividade.date).format('YYYY-MM-DD');
    console.log(atividade);
    console.log(this.createDate);
  }

  // pega a atividade que foi clicada
  eventClick(atividade) {
  	this.atividadeClick++;
  	this.atividade = atividade.event;
  }

  // renderiza uma atividade nova no calendário
  createAtividade(atividade) {
    this.ucCalendar.fullCalendar('renderEvent', atividade, true);
  }

  // atualiza se a atividade for movida para uma data dentro do evento, senão não deixa e emite um toast de erro
  updateEvent(atividade) {

    let start = moment(this.evento.start);
    let end = moment(this.evento.end);

    let newDateStart = moment(atividade.event.start.format());
    let newDateEnd = moment(atividade.event.end.format());

    if((newDateStart.diff(start, 'hours') < 0) || (end.diff(newDateEnd, 'hours') < 0)) {
    	atividade.event.start = moment(atividade.event.start.subtract(atividade.duration).format());
    	atividade.event.end = moment(atividade.event.end.subtract(atividade.duration).format());
    	this.ucCalendar.fullCalendar('updateEvent', atividade.event);
    	this.errorUpdateToast.emit('toast');
    } else {
      this.atividadesService.update(atividade.event.id, 'data', [newDateStart, newDateEnd]).subscribe(
        (res) => {
          console.log(res);
      });
    }
  }

  // apaga a atividade do calendário
  deleteAtividade(eventId) {
    this.ucCalendar.fullCalendar('removeEvents', eventId);
  }

  // atualiza o titulo da atividade no calendário
  updateTitle(event) {
    let atividade = this.ucCalendar.fullCalendar('clientEvents', event.id);
    atividade[0].title = event.title;
    this.ucCalendar.fullCalendar('updateEvent', atividade[0]);
  }
}
