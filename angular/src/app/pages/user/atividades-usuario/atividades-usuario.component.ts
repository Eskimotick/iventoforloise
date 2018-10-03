import { Component, OnInit, ViewChild } from '@angular/core';
import { CalendarComponent } from 'ng-fullcalendar';
import { Options } from 'fullcalendar';
import * as moment from 'moment'; 

import { UserService } from '../../../services/user/user.service';

@Component({
  selector: 'app-atividades-usuario',
  templateUrl: './atividades-usuario.component.html',
  styleUrls: ['./atividades-usuario.component.css']
})
export class AtividadesUsuarioComponent implements OnInit {

	// variaveis para funcionamento do fullcalendar
  @ViewChild(CalendarComponent) ucCalendar: CalendarComponent;
  calendarOptions: Options;

  // carregando os eventos do calendário
  evento: any = {
  	id: 0, title: 'Evento 1', start: '2018-09-04', end: '2018-09-11', rendering: 'background'
  };

  // para pegar a atividade que foi clicada
  atividade: any;
  atividadeClick: number;

  constructor(private userService: UserService) {
  	this.atividadeClick = 0;
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

		this.userService.myPackageActivities().subscribe(
			(res) => {
				console.log(res);
        this.initEvents(res.data);
		});  	
  }

  initEvents(atividadesJson) {
    if(this.ucCalendar) {
      let atividade: any = {};
    	this.ucCalendar.fullCalendar('renderEvent', this.evento, true);
      for(let i = 0; i < atividadesJson.length; i++) {
        atividade.id = atividadesJson[i].id;
        atividade.title = atividadesJson[i].titulo;
        atividade.start = moment(atividadesJson[i].data_inicio).format('YYYY-MM-DDTHH:mm');
        atividade.end = moment(atividadesJson[i].data_fim).format('YYYY-MM-DDTHH:mm');
        atividade.palestrante = atividadesJson[i].palestrante;
        atividade.descricao = atividadesJson[i].descricao;
        atividade.status = atividadesJson[i].status;
        atividade.qntdVagas = atividadesJson[i].vagas;
        atividade.image = atividadesJson[i].img;
        this.ucCalendar.fullCalendar('renderEvent', atividade, true);
      }
    } else {
      setTimeout(() => {
        this.initEvents(atividadesJson);
      }, 500);
    }
  }


  // pega a atividade que foi clicada
  eventClick(atividade) {
  	console.log(atividade);
  	this.atividadeClick++;
  	this.atividade = atividade.event;
  }
}
