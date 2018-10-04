import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { tap } from 'rxjs/operators';


import { environment } from '../../../environments/environment.prod';

@Injectable({
  providedIn: 'root'
})
export class HospedagemService {

  private token: string;
	private headers;

  constructor(private http: HttpClient) {
    this.token = localStorage.getItem('token');
  	this.headers = {
  		headers: new HttpHeaders({ 'Accept': 'application/json', 'Authorization': `Bearer ${this.token}`})
  	};
  }

  index(): Observable<any>{
    return this.http.get(environment.api_url+'admin/hospedagens', this.headers);


  }
}
