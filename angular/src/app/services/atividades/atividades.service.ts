import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';
import * as moment from 'moment';

import { environment } from '../../../environments/environment.prod';

@Injectable({
  providedIn: 'root'
})
export class AtividadesService {

	private token: string;
	private headers;

  constructor(public http: HttpClient) {
  	this.token = localStorage.getItem('token');
  	this.headers = {
  		headers: new HttpHeaders({ 'Accept': 'application/json', 'Authorization': `Bearer ${this.token}`})
  	};
  }

  store(atividade):Observable<any> {
  	return this.http.post<any>(environment.api_url + 'admin/atividades', {
  		'titulo': atividade.title,
  		'descricao': atividade.descricao,
  		'palestrante': atividade.palestrante,
  		'data_inicio': moment(atividade.start).format('YYYY-MM-DD HH:mm:ss'),
  		'data_fim': moment(atividade.end).format('YYYY-MM-DD HH:mm:ss'),
  		'vagas': atividade.qntdVagas,
  		'vagas_ocupadas': 0,
  		'status': atividade.status
  	}, this.headers);
  }

}
