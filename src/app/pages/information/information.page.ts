import { Component, OnInit, ApplicationRef } from '@angular/core';
import { Article } from 'src/app/interfaces/interface';
import { GlobalVar } from 'src/app/services/GlobalVar';
import { DataService } from '../../services/data.service';
import { PushService } from '../../services/push.service';

@Component({
  selector: 'app-information',
  templateUrl: './information.page.html',
  styleUrls: ['./information.page.scss'],
})
export class InformationPage implements OnInit {

  infos: Article[] = [];
  
  constructor( private dataService: DataService, 
               private global: GlobalVar, 
               private pushService: PushService ) { 
                
               }

  ngOnInit() {
    //push
    this.pushService.pushListener.subscribe(noti => {
      this.loadInformation();
      console.log("Ha llegado un push");
    });
    this.loadInformation();
  }

  loadInformation(  ) {
    this.dataService.getInfo( this.global ).subscribe( resp => {
      this.infos.push( ...resp['articles'] );
    });
  }
}
