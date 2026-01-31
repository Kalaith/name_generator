export interface PersonNameResult {
  name: string;
  firstName: string;
  lastName: string;
  culture: string;
  gender: string;
  method: string;
  origin: string;
  meaning: string;
  pronunciation: string;
  period: string;
}

export interface PeopleParams {
  count: number;
  gender: string;
  culture: string;
  method: string;
  type: string;
  period: string;
  dialect: string;
  excludeReal: boolean;
}

export interface Option {
  value: string;
  label: string;
}

// Extended option type for dialects with culture filtering
export interface DialectOption extends Option {
  cultures: string[];
}
