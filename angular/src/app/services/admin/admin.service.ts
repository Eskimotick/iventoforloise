import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';
import { Router } from '@angular/router';

import { environment } from '../../../environments/environment.prod';

@Injectable({
  providedIn: 'root'
})
export class AdminService {

	private token: string;
	private headers;

  constructor(public http: HttpClient) {
  	this.token = localStorage.getItem('token');
  	this.headers = {
  		headers: new HttpHeaders({ 'Accept': 'application/json', 'Authorization': `Bearer ${this.token}`})
  	};
  }

  inscreveUser(cpfUser, idAtividade) {
  	return this.http.post<any>(environment.api_url + 'admin/atividades/inscricao/' + cpfUser + '-' + idAtividade, {} , this.headers);
  }
}
