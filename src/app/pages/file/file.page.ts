import { Component, OnInit } from '@angular/core';
import { DataService } from 'src/app/services/data.service';
import { GlobalVar } from 'src/app/services/GlobalVar';

@Component({
  selector: 'app-file',
  templateUrl: './file.page.html',
  styleUrls: ['./file.page.scss'],
})
export class FilePage implements OnInit {

  categories: string[] = ['absencies', 'observaciones', 'incidencias'];
  file: string[][];
  category: string = 'absencies';
  nomCategories: string[] = [];

  constructor( private dataService: DataService, 
               private global: GlobalVar ) {
    this.nomCategories[this.categories[0]]='absències';
    this.nomCategories[this.categories[1]]='observacions';
    this.nomCategories[this.categories[2]]='incidències';
   }

  ngOnInit() {
    this.loadFile( this.categories[0] );
  }

  changeFile( event ) {
    this.category = event.detail.value;
    this.loadFile( event.detail.value );
  }

  loadFile( category: string ) {
    this.dataService.getFile( this.global ).subscribe( resp => {
      this.file = resp[category];
    });
  }

}
