import { Component, OnInit } from '@angular/core';
import { DateTimeAdapter } from 'ng-pick-datetime';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {

  constructor(dateTimeAdapter: DateTimeAdapter<any>) {
  	dateTimeAdapter.setLocale('pt-br');
  }

  ngOnInit() {
  }

}
