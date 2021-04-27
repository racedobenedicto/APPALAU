import { Component, Input, OnInit } from '@angular/core';
import { Article } from 'src/app/interfaces/interface';

@Component({
  selector: 'app-infos',
  templateUrl: './infos.component.html',
  styleUrls: ['./infos.component.scss'],
})
export class InfosComponent implements OnInit {

  @Input() infos: Article[] = [];
  
  constructor() { }

  ngOnInit() {}

}
