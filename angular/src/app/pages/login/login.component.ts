import { Component, OnInit } from '@angular/core';

import { AuthService } from '../../services/auth/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  constructor(private authService: AuthService) { }

  ngOnInit() {
  }

  onLogin(credentials) {
  	console.log(credentials.value);
  	this.authService.login(credentials.value.email, credentials.value.password).subscribe(
  		(res) => {
  			console.log(res)
  	});
  }

}
