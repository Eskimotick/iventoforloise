import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { tap } from 'rxjs/operators';
import * as moment from 'moment';

import { environment } from '../../../environments/environment.prod';

@Injectable({
  providedIn: 'root'
})
export class AtividadesService {

  private atividades: Observable<any>;
	private token: string;
	private headers;

  constructor(public http: HttpClient) {
  	this.token = localStorage.getItem('token');
  	this.headers = {
  		headers: new HttpHeaders({ 'Accept': 'application/json', 'Authorization': `Bearer ${this.token}`})
  	};
  }

  index():Observable<any> {
    if(this.atividades) 
      return of(this.atividades);
    else {
      return this.http.get<any>(environment.api_url + 'admin/atividades/', this.headers).pipe(
        tap(atividades => this.atividades = atividades)
      );
    }
  }

  store(atividade, pacotes):Observable<any> {
  	return this.http.post<any>(environment.api_url + 'admin/atividades', {
  		titulo: atividade.title,
  		descricao: atividade.descricao,
  		palestrante: atividade.palestrante,
  		data_inicio: moment(atividade.start).format('YYYY-MM-DD HH:mm:ss'),
  		data_fim: moment(atividade.end).format('YYYY-MM-DD HH:mm:ss'),
  		vagas: atividade.qntdVagas,
  		vagas_ocupadas: 0,
  		status: atividade.status,
      pacotes: pacotes,
      img_path: atividade.image
  	}, this.headers).pipe(
        tap(atividades => this.atividades = null)
      );
  }

  update(id, onEditKey, onEditValue):Observable<any> {
    let body;
    if(onEditKey == 'data') {
      body = {
        data_inicio: onEditValue[0].format('YYYY-MM-DD HH:mm:ss'),
        data_fim: onEditValue[1].format('YYYY-MM-DD HH:mm:ss')
      }
    } else {
      if(onEditKey == 'pacotes')
        onEditValue = onEditValue.join(',');
      body = {[onEditKey]: onEditValue};
    }
    return this.http.put<any>(environment.api_url + 'admin/atividades/' + id, body, this.headers).pipe(
        tap(atividades => this.atividades = null)
      );
  }

  delete(id):Observable<any> {
    return this.http.delete<any>(environment.api_url + 'admin/atividades/' + id, this.headers).pipe(
      tap(() => this.atividades = null
    ));
  }

}
