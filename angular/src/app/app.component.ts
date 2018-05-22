import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { environment } from '../environments/environment';

import { ToastrService } from 'ngx-toastr';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {

  constructor(public router: Router,
              public toastr: ToastrService) {

  }

  ngOnInit() {
    this.router.navigate(['login']);
  }


}
