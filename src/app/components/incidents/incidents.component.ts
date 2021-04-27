import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-incidents',
  templateUrl: './incidents.component.html',
  styleUrls: ['./incidents.component.scss'],
})
export class IncidentsComponent implements OnInit {

  @Input() fileIncidents: string[][];
  
  constructor() { }

  ngOnInit() {}

}
