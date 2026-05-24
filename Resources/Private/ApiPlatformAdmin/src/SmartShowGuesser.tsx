import { Introspecter, ShowGuesser } from "@api-platform/admin";
import type { Field } from "@api-platform/api-doc-parser";
import { useResourceContext } from "react-admin";
import { SmartFieldGuesser } from "./SmartFieldGuesser";

interface IntrospectedProps {
  readableFields: Field[];
  [key: string]: unknown;
}

const IntrospectedSmartShow = ({ readableFields, ...props }: IntrospectedProps) => (
  <ShowGuesser {...props}>
    {readableFields.map((field) => (
      <SmartFieldGuesser key={field.name} source={field.name} />
    ))}
  </ShowGuesser>
);

export const SmartShowGuesser = (props: Record<string, unknown>) => {
  const resource = useResourceContext(props as { resource?: string });
  return (
    <Introspecter
      component={IntrospectedSmartShow}
      resource={resource!}
      includeDeprecated={true}
      {...props}
    />
  );
};
