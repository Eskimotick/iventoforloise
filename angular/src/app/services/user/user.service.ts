import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { tap } from 'rxjs/operators';

import { environment } from '../../../environments/environment.prod';

@Injectable({
  providedIn: 'root'
})
export class UserService {

	private atividades: Observable<any>;
	private token: string;
	private headers;

  constructor(private http: HttpClient) {
  	this.token = localStorage.getItem('token');
  	this.headers = {
  		headers: new HttpHeaders({ 'Accept': 'application/json', 'Authorization': `Bearer ${this.token}`})
  	};
  }

  myPackageActivities():Observable<any> {
  	if(this.atividades) 
      return of(this.atividades);
    else {
      return this.http.get<any>(environment.api_url + 'activity', this.headers).pipe(
        tap(atividades => this.atividades = atividades)
      );
    }
  }

  inscreveAtividadePacote(idAtividade):Observable<any> {
  	return this.http.post<any>(environment.api_url + 'users/inscreve-atividade/' + idAtividade, {}, this.headers);
  }

  desinscreveAtividade(idAtividade):Observable<any> {
  	return this.http.post<any>(environment.api_url + 'users/remove-atividade/' + idAtividade, {}, this.headers);
  }
}
